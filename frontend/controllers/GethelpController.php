<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\GhPacket;
use common\models\GhTransfer;
use common\models\AmountGethelp;
use common\models\TokenForgethelp;
use common\models\BitcoinWallet;
use common\models\Converted;
use common\models\TokenRequest;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use frontend\models\GhBonuswallet;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class GethelpController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('gethelp/index'));
        }
        $this->canUser();
        
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

        $model_bonus = new GhBonuswallet;
        $model_main = new GhTransfer; 
		$model_bonus_db = new GhTransfer;
        $BitcoinWallet = new BitcoinWallet;
 
        
        //get account bitcoin wallet max amount
        $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'max');
        //get balance account_wallettoken
        $balance_wallettoken = $client->getBalance($account_wallettoken);

    	$user = User::findOne(Yii::$app->user->identity->id);

        $address_btc = $client->getAddressList($user->username);

        //get amount sh/gh amount for level user
        $amountsh = AmountGethelp::find()->where(['level'=>$user->level])->one();

        $bonus_wallet = $user->manager_bonus + $user->referral_bonus;
        $main_wallet  = $user->wallet;


        //get total amount gh in a month by user_id
        $total_amount = $model_bonus->findTotalghinmonth(Yii::$app->user->identity->id);

        //get all gh transfer by id user
        $gethelptransfer = GhTransfer::find()->where(['user_id'=>Yii::$app->user->identity->id])->orderBy(['created_at'=>SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $gethelptransfer,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);   

        if ($model_bonus->load(Yii::$app->request->post())) {

    		$amount = $model_bonus->amount;
            // get token for amount gethelp from bonus wallet
            $token = $model_bonus->getTokenamount($amount, GhTransfer::STATUS_BONUS);
            if($balance_wallettoken <= $amount){
                Yii::$app->getSession()->setFlash('error_bonus', Yii::$app->languages->getLanguage()['your_request_cannot_be_processed_at_this_time_please_try_again_later'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }
    		if($amount > $bonus_wallet){
    			Yii::$app->getSession()->setFlash('error_bonus', Yii::$app->languages->getLanguage()['your_bonus_wallet_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
    		}
            if($amount * $token > $user->token){
                Yii::$app->getSession()->setFlash('error_bonus', Yii::$app->languages->getLanguage()['your_token_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }
            if($amount > ($amountsh->amountgh - $total_amount)){
                $minamount = $amountsh->amountsh - $total_amount;
                Yii::$app->getSession()->setFlash('error_bonus', Yii::$app->languages->getLanguage()['the_amount_you_can_sh_this_month_is'].' '.$minamount.'Btc !');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }


            $model_bonus_db->user_id = $user->id;
		    $model_bonus_db->amount = $amount;
		    $model_bonus_db->status = GhTransfer::STATUS_BONUS;
		    $model_bonus_db->publish = GhTransfer::PUBLISH_NOACTIVE;
		    $model_bonus_db->created_at = time();
		    $model_bonus_db->updated_at = time();
		    if($model_bonus_db->save()){
		    	if($user->manager_bonus >= $amount){
		    		$user->manager_bonus = $user->manager_bonus - $amount;
		    		$user->token = $user->token - $token;
		    		$user->save();
		    	}else{
		    		$tamp = $amount - $user->manager_bonus;
		    		$user->manager_bonus = 0;
		    		$user->referral_bonus = $user->referral_bonus - $tamp;
		    		$user->token = $user->token - $token;
		    		$user->save();
		    	}

                $TokenRequest = new TokenRequest;
                $TokenRequest->user_id = $user->id;
                $TokenRequest->amount = $token;
                $TokenRequest->balance = $user->token;
                $TokenRequest->bitcoin = 0;
                $TokenRequest->mode = TokenRequest::MODE_GH;
                $TokenRequest->publish = TokenRequest::PUB_ACTIVE;
                $TokenRequest->created_at = time();
                $TokenRequest->save();
		    	
		    	

		    	//****************************************************************//
                //transfer bitcoin from bitcoind wallet to system bitcoind wallet.//
                //****************************************************************//

                //get account bitcoin wallet max amount
                $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'max');
                //get address username
                $address_wallettoken = $client->getAddress($user->username);
                //send bitcoin to SH/GH bitcoin wallet
                //$sendbitcoin = $client->withdraw($account_wallettoken, $address_wallettoken, $amount);
                Yii::$app->getSession()->setFlash('success_bonus', Yii::$app->languages->getLanguage()['gh_completed_it_will_take_some_time_for_the_funds_to_be_credited_to_your_bitway_wallet'].'!');

		    	return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
		    }
        } 


        if ($model_main->load(Yii::$app->request->post())) {
    		$amount = $model_main->amount;
            $token = $model_main->getTokenamount($amount, GhTransfer::STATUS_MAIN);
            if($balance_wallettoken <= $amount){
                Yii::$app->getSession()->setFlash('error_main', Yii::$app->languages->getLanguage()['your_request_cannot_be_processed_at_this_time_please_try_again_later'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }
    		if($amount > $main_wallet){
    			Yii::$app->getSession()->setFlash('error_main', Yii::$app->languages->getLanguage()['your_main_wallet_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
    		}
            if($amount * $token > $user->token){
                Yii::$app->getSession()->setFlash('error_main', Yii::$app->languages->getLanguage()['your_token_balance_is_not_enough_to_perform_this_action'].'!');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }
            if($amount > ($amountsh->amountgh - $total_amount)){
                $minamount = $amountsh->amountsh - $total_amount;
                Yii::$app->getSession()->setFlash('error_main', Yii::$app->languages->getLanguage()['the_amount_you_can_sh_this_month_is'].' '.$minamount.'Btc !');
                return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
            }
            $model_main->user_id = $user->id;
		    $model_main->amount = $amount;
		    $model_main->status = GhTransfer::STATUS_MAIN;
		    $model_main->publish = GhTransfer::PUBLISH_NOACTIVE;
		    $model_main->created_at = time();
		    $model_main->updated_at = time();
		    if($model_main->save()){
		    	$user->wallet = $user->wallet - $amount;
		    	$user->token = $user->token - $token;
		    	$user->save();

                $TokenRequest = new TokenRequest;
                $TokenRequest->user_id = $user->id;
                $TokenRequest->amount = $token;
                $TokenRequest->balance = $user->token;
                $TokenRequest->bitcoin = 0;
                $TokenRequest->mode = TokenRequest::MODE_GH;
                $TokenRequest->publish = TokenRequest::PUB_ACTIVE;
                $TokenRequest->created_at = time();
                $TokenRequest->save();

		    	//****************************************************************//
                //transfer bitcoin from bitcoind wallet to system bitcoind wallet.//
                //****************************************************************//

                //get account bitcoin wallet max amount
                $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'max');
                //get address username
                $address_wallettoken = $client->getAddress($user->username);
                //send bitcoin to SH/GH bitcoin wallet
                //$sendbitcoin = $client->withdraw($account_wallettoken, $address_wallettoken, $amount);
                
                Yii::$app->getSession()->setFlash('success_main', Yii::$app->languages->getLanguage()['gh_completed_it_will_take_some_time_for_the_funds_to_be_credited_to_your_bitway_wallet'].'!');
		    	return $this->render('index', ['model_bonus'=>$model_bonus, 'model_main'=>$model_main, 'user'=>$user, 'dataProvider' => $dataProvider, 'address_btc' => $address_btc, 'token' =>$user->token]);
		    }
        }    

        

        return $this->render('index', [
        	'model_bonus'=>$model_bonus,
        	'model_main'=>$model_main,
        	'user'=>$user,
            'dataProvider' => $dataProvider,
            'address_btc' => $address_btc,
            'token' =>$user->token,
        ]);
    }

    public function actionGettokenforghbonus(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        if($type == GhTransfer::STATUS_BONUS){
            $TokenForgethelp = TokenForgethelp::find()->where(['<', 'min_bonusw', (float)$amount])->andWhere(['>=', 'max_bonusw', (float)$amount])->one();
        }
        if($type == GhTransfer::STATUS_MAIN){
            $TokenForgethelp = TokenForgethelp::find()->where(['<', 'min_mainw', (float)$amount])->andWhere(['>=', 'max_mainw', (float)$amount])->one();
        }
        if(!empty($TokenForgethelp)){
            return $TokenForgethelp->token;
        } else {
            return 0;
        }
    }


    public function actionStandbygethelp(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $BitcoinWallet = new BitcoinWallet;
        $standbytimegh = Converted::find()->where(['object'=>'standbytimegh'])->one();
        $ghtransfer  = GhTransfer::find()->where(['publish'=>GhTransfer::PUBLISH_NOACTIVE])->all();
        foreach ($ghtransfer as $key => $gethelp) {
            if( (60 * $standbytimegh->value +$gethelp->created_at) <= time() ){
                $gh = GhTransfer::findOne($gethelp->id);
                $user = User::findOne($gh->user_id);
                //get account bitcoin wallet max amount
                $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'max');
                //get address username
                $address_wallettoken = $client->getAddress($user->username);
                //send bitcoin to SH/GH bitcoin wallet
                $sendbitcoin = $client->withdraw($account_wallettoken, $address_wallettoken, $gh->amount);

                if($sendbitcoin){
                    $gh->publish = GhTransfer::PUBLISH_ACTIVE;
                    $gh->save();
                    return 'ghsent';
                }
            } else{
                return 'null';
            }
        }
    }
}
