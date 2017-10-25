<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\ShTransfer;
use common\models\ShPacket;
use common\models\AmountGethelp;
use common\models\ShWithdraw;
use common\models\ManagerBonus;
use common\models\ReferralBonus;
use common\models\TokenRequest;
use common\models\BitcoinWallet;
use common\models\LevelSetting;
use frontend\models\ProfitBonus;
use frontend\models\SendhelpTransfer;
use common\models\BonusHistory;
use common\models\TokenForsendhelp;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SendhelpController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('sendhelp/index'));
        }
        $this->canUser();

        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $model = new ShTransfer;
        $sendhelpTransfer = new SendhelpTransfer;
        $BitcoinWallet = new BitcoinWallet;
        $bitcoin_rate = file_get_contents('https://blockchain.info/tobtc?currency=USD&value=1');
        //check shtransfer completed
        $model->checkallShtransfer;
            
    	$btc = $client->getBalance(Yii::$app->user->identity->username);
        $token = Yii::$app->user->identity->token;
    	$level = Yii::$app->user->identity->level;
        $id = Yii::$app->user->identity->id;

        //get all sh transfer active
        $active_sh = ShTransfer::find()->where(['user_id'=>$id, 'publish'=>ShTransfer::PUBLISH_ACTIVE])->andWhere(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_DESC])->all();
    	//get all sh transfer complete
        $complete_sh = ShTransfer::find()->where(['user_id'=>$id, 'publish'=>ShTransfer::PUBLISH_ACTIVE, 'status'=> ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
        //get amount sh/gh amount for level user
        $amountsh = AmountGethelp::find()->where(['level'=>$level])->one();

        //get total amount sh in a month by user_id
        $total_amount = $model->findTotalshinmonth(Yii::$app->user->identity->id);
        
        //get amount sh active in this month
        //$shactive_thismonth = $model->findAmountshActiveThismonth(Yii::$app->user->identity->id);
        //get amount sh permitted in this month
        $sh_permitted = LevelSetting::find()->select('amount_sh')->where(['level'=>Yii::$app->user->identity->level])->one();

        if(!empty($total_amount)){
            $total_amount_sh = $total_amount;
        }else{
            $total_amount_sh = 0;
        }

        //get all sh transfer by id user
        $sendhelptransfer = ShTransfer::find()->where(['user_id'=>Yii::$app->user->identity->id, 'publish'=>ShTransfer::PUBLISH_ACTIVE, 'status'=> ShTransfer::STATUS_COMPLETED])->andWhere(['>', 'amount', 0])->orderBy(['created_at'=>SORT_DESC])->limit(10)->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $sendhelptransfer,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);


    	if ($sendhelpTransfer->load(Yii::$app->request->post()) ) {
    		$amount = $sendhelpTransfer->amount;
            //get token for this sendhelp
            $tokenforsh = $sendhelpTransfer->getTokenamount($amount);
            //get packet snedhelp from amount sendhelp
            $packet = ShPacket::find()->where(['<', 'min_amount', (float)$amount])->andWhere(['>=', 'max_amount', (float)$amount])->orderBy(['max_amount' => SORT_ASC])->one();
            
            //check amount sh permited in this month
            if( (!empty($active_sh)) && (count($active_sh) >= $sh_permitted->amount_sh) ){
                Yii::$app->getSession()->setFlash('error', Yii::$app->languages->getLanguage()['you_already_have_the_maximum_number_allowed_sh'].'!');
                return $this->render('index', ['sendhelpTransfer'=>$sendhelpTransfer, 'active_sh'=>$active_sh, 'complete_sh'=>$complete_sh, 'dataProvider' => $dataProvider, 'amount_in_month' => $amountsh->amountsh, 'amount_can_sh' => $amountsh->amountsh - $total_amount]);
            }
            // @TODO: Testing after
            // check bitcoind wallet
    		if($amount > ($btc / $bitcoin_rate) ){
    			Yii::$app->getSession()->setFlash('error', Yii::$app->languages->getLanguage()['your_bitcoin_wallet_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['sendhelpTransfer'=>$sendhelpTransfer, 'active_sh'=>$active_sh, 'complete_sh'=>$complete_sh, 'dataProvider' => $dataProvider, 'amount_in_month' => $amountsh->amountsh, 'amount_can_sh' => $amountsh->amountsh - $total_amount]);
    		}

            // check token from amount sendhelp
            if($tokenforsh > $token){
                Yii::$app->getSession()->setFlash('error', Yii::$app->languages->getLanguage()['your_token_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['sendhelpTransfer'=>$sendhelpTransfer, 'active_sh'=>$active_sh, 'complete_sh'=>$complete_sh, 'dataProvider' => $dataProvider, 'amount_in_month' => $amountsh->amountsh, 'amount_can_sh' => $amountsh->amountsh - $total_amount]);
            }
            if($amount > ($amountsh->amountsh - $total_amount)){
                $minamount = $amountsh->amountsh - $total_amount;
                Yii::$app->getSession()->setFlash('error', Yii::$app->languages->getLanguage()['the_amount_you_can_sh_this_month_is'].' '.$minamount.'Btc !');
                return $this->render('index', ['sendhelpTransfer'=>$sendhelpTransfer, 'active_sh'=>$active_sh, 'complete_sh'=>$complete_sh, 'dataProvider' => $dataProvider, 'amount_in_month' => $amountsh->amountsh, 'amount_can_sh' => $amountsh->amountsh - $total_amount]);
            }

            $sh_transfer = new ShTransfer;
            $sh_transfer->user_id = $id;
            $sh_transfer->amount = $amount;
            $sh_transfer->inc_days = time(); // last time withdraw 
            $sh_transfer->sh_packet_id = $packet->id;
            $sh_transfer->min_days = $packet->min_days;
            $sh_transfer->max_days = $packet->max_days;
            $sh_transfer->status = ShTransfer::STATUS_HOLD;
            $sh_transfer->publish = ShTransfer::PUBLISH_ACTIVE;
            //$sh_transfer->mode = ShTransfer::MODE_NOACTIVE;
            $sh_transfer->mode = ShTransfer::MODE_ACTIVE;
            $sh_transfer->created_at = time();
            $sh_transfer->updated_at = time();

            $user = User::findOne($id);
            $user->token = $user->token - $tokenforsh;
            $user->shstatus = User::SHSTATUS_ACTIVE;
            $user->save();

            $TokenRequest = new TokenRequest;
            $TokenRequest->user_id = $user->id;
            $TokenRequest->amount = $tokenforsh;
            $TokenRequest->balance = $user->token;
            $TokenRequest->bitcoin = 0;
            $TokenRequest->mode = TokenRequest::MODE_SH;
            $TokenRequest->publish = TokenRequest::PUB_ACTIVE;
            $TokenRequest->created_at = time();
            $TokenRequest->save();

            // update number_f1shactive for referral user
            if(!empty($user->referral_user_id)){
                $referral_user = User::findOne($user->referral_user_id);
                $referral_user->number_f1shactive = $referral_user->number_f1shactive + 1;
                $referral_user->save();
            }
            


            //****************************************************************//
            //transfer bitcoin from bitcoind wallet to system bitcoind wallet.//
            //****************************************************************//

            //get bitcoin wallet min amount
            // @TODO: Testing after
            $address_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'min');
            //send bitcoin to SH/GH bitcoin wallet
            // @TODO: Testing after
            $amount_btc = $amount * $bitcoin_rate;
            $sendbitcoin = $client->withdraw($user->username, $address_wallettoken, $amount_btc);
            if($sendbitcoin){
            //if(true){
                Yii::$app->getSession()->setFlash('success', Yii::$app->languages->getLanguage()['send_help_completed_successfully'].'!');
            }else{
                Yii::$app->getSession()->setFlash('error', Yii::$app->languages->getLanguage()['send_help_failed'].'!');
                return $this->redirect(['index']);
            }

            if($sh_transfer->save()){

                // *******************************************************//
                //  referal bonus and manager bonus for last sh completed //
                // *******************************************************//

                //get referral parent 
                $referral_parent =  $user->referral_user_id;
                if(!empty($referral_parent)){
                    $user_referral = User::findOne($referral_parent);
                    $profit_referral = ReferralBonus::find()->where(['level'=>$user_referral->level])->one();
                    $referral_bonus = $sh_transfer->amount *  $profit_referral->profit / 100;
                    $user_referral->referral_bonus = $user_referral->referral_bonus + $referral_bonus;
                    $user_referral->amount_shf1 = $user_referral->amount_shf1 + $sh_transfer->amount;
                    $user_referral->save();


                    //insert bonus_history
                    $bonus_history = new BonusHistory;
                    $bonus_history->user_id = $user->id;
                    $bonus_history->reciever_id = $referral_parent;
                    $bonus_history->sh_transfer_id = $sh_transfer->id;
                    $bonus_history->amount = $referral_bonus;
                    $bonus_history->wall_type = BonusHistory::REFERRAL_BONUS;
                    $bonus_history->created_at = time();
                    $bonus_history->updated_at = time();
                    $bonus_history->save();
                }

                // get manager parent 
                $manager_parent = $user->findManagerparent($user->id);


                if(!empty($manager_parent)){
                    foreach ($manager_parent as $key => $userid) {
                        $user_manager = User::findOne($userid);
                        if(!empty($user_manager)){

                            //kiểm tra số tầng mà user_manager này có thể hưởng manager bonus
                            $floor = LevelSetting::find()->where(['level'=>$user_manager->level])->one();
                            
                            if($floor->manager_bonus >= $key+1){
                                $profit_manager = ManagerBonus::find()->where(['floor'=>$key+1])->one();
                                $manager_bonus = $sh_transfer->amount *  $profit_manager->profit / 100;
                                
                                if(!empty($user_manager)){
                                    $user_manager->manager_bonus = $user_manager->manager_bonus + $manager_bonus;
                                    $user_manager->save();
                                    
                                    //insert bonus_history
                                    $bonus_history = new BonusHistory;
                                    $bonus_history->user_id = $user->id;
                                    $bonus_history->reciever_id = $userid;
                                    $bonus_history->sh_transfer_id = $sh_transfer->id;
                                    $bonus_history->amount = $manager_bonus;
                                    $bonus_history->wall_type = BonusHistory::MANAGER_BONUS;
                                    $bonus_history->created_at = time();
                                    $bonus_history->updated_at = time();
                                    $bonus_history->save();

                                }

                            }

                        }
                    }
                }


                //******************************//
                //***update level all member****//
                //******************************//
                $user->updateLevel($user->id);
                $user->updateLevel($user->referral_user_id);


                //get all sh transfer by id user
                $sendhelptransfer = ShTransfer::find()->where(['user_id'=>Yii::$app->user->identity->id, 'publish'=>ShTransfer::PUBLISH_ACTIVE, 'status'=> ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_DESC])->limit(10)->all();
                $dataProvider = new ArrayDataProvider([
                    'key' => 'id',
                    'allModels' => $sendhelptransfer,
                    'pagination' => [
                        'pageSize' => 10
                    ],
                ]);

                $total_amount = $model->findTotalshinmonth(Yii::$app->user->identity->id);
                
                //get all sh transfer active
                $active_sh = ShTransfer::find()->where(['user_id'=>$id, 'publish'=>ShTransfer::PUBLISH_ACTIVE])->andWhere(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
                $complete_sh = ShTransfer::find()->where(['user_id'=>$id, 'publish'=>ShTransfer::PUBLISH_ACTIVE, 'status'=> ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
                return $this->redirect(['index', 'sendhelpTransfer'=>$sendhelpTransfer, 'active_sh'=>$active_sh, 'complete_sh'=>$complete_sh, 'dataProvider' => $dataProvider, 'amount_in_month' => $amountsh->amountsh, 'amount_can_sh' => $amountsh->amountsh - $total_amount,]);
            }
    	} 
        return $this->render('index', [
            'sendhelpTransfer'=>$sendhelpTransfer, 
            'active_sh'=>$active_sh, 
            'complete_sh'=>$complete_sh,
            'dataProvider' => $dataProvider,
            'amount_in_month' => $amountsh->amountsh,
            'amount_can_sh' => $amountsh->amountsh - $total_amount,
        ]);
    }

    public function actionWithdrawprofit(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id_sh = $_POST['id_sh'];
        $id_user = $_POST['id_user'];

        $level = Yii::$app->user->identity->level;

        $sh_transfer = ShTransfer::findOne($id_sh);

        $profit_packet = $sh_transfer->getProfitdailyUserlevel($sh_transfer->id);

        $daily_profit = $sh_transfer->amount * $profit_packet / 100 / 86400;
        $amount_profit = (time()- $sh_transfer->inc_days) * $daily_profit;

        $profit = round($amount_profit, 8);

        //add to gh wallet
        $user = User::findOne($id_user);
        $user->wallet = $user->wallet + $profit;
        $user->save();

        //update inc_days in sh transfer
        $sh_transfer->inc_days = time();
        $sh_transfer->save();

        //insert sh withdraw
        $sh_withdraw = new ShWithdraw;
        $sh_withdraw->id_shtransfer = $id_sh;
        $sh_withdraw->amount = $profit;
        $sh_withdraw->created_at = time();
        if($sh_withdraw->save()){
            return number_format($profit, 8);
        }
    }


    public function actionGettokenforsh(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $amount = $_POST['amount'];
        $TokenForsendhelp = TokenForsendhelp::find()->where(['<', 'min_amount', (float)$amount])->andWhere(['>=', 'max_amount', (float)$amount])->one();
        return $TokenForsendhelp->token;
    }


    public function actionWithdrawcapital(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id_sh = $_POST['id_sh'];
        $id_user = $_POST['id_user'];

        $level = Yii::$app->user->identity->level;

        $sh_transfer = ShTransfer::findOne($id_sh);
        $profit_packet = $sh_transfer->getProfitdaily($sh_transfer->id);

        //daily profit in 1 second
        $daily_profit = $sh_transfer->amount * $profit_packet / 100 / 86400;
        //total daily profit from last withdraw to now
        $amount_profit = (time()- $sh_transfer->inc_days) * $daily_profit;

        $profit = round($amount_profit, 8);

        //add to gh wallet
        $user = User::findOne($id_user);
        $user->wallet = $user->wallet + $profit + $sh_transfer->amount;
        $user->save();

        //update inc_days in sh transfer
        $sh_transfer->inc_days = time();
        $sh_transfer->status = ShTransfer::STATUS_COMPLETED;
        $sh_transfer->save();

        //insert sh withdraw
        $sh_withdraw = new ShWithdraw;
        $sh_withdraw->id_shtransfer = $id_sh;
        $sh_withdraw->amount = $profit;
        $sh_withdraw->created_at = time();
        $sh_withdraw->save();

        return $sh_transfer->amount + $profit;
    }
}
