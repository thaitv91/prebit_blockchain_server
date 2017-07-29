<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\WithdrawBitcoin;
use common\models\Withdrawtobitcoin;
use common\models\Cashwithdraw;
use common\models\Currency;
use common\models\BitcoinWallet;
use common\models\BuyBtc;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use common\extensions\ConvertBitcoin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


class BitwalletController extends FrontendController
{
    public function actionIndex()
    {
		
    	if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('bitwallet/index'));
        }
        $this->canUser();
        
        define("IN_WALLET", true);
        $user = User::findOne(Yii::$app->user->identity->id);

        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $address_btc = $client->getAddressList($user->username);
        $balance_btc = $client->getBalance($user->username);
        $transction_btc = $client->getTransactionList($user->username);
        
        $BuyBtc = BuyBtc::find()->groupBy(['country_id'])->orderBy(['country_id'=>SORT_ASC])->all();

        $country_id = BuyBtc::find()->groupBy(['country_id'])->orderBy(['country_id'=>SORT_ASC])->one();

        $listAddress = BuyBtc::find()->where(['country_id' => $country_id->country_id])->orderBy(['country_id'=>SORT_ASC])->all();

        //get account sg/gh, token, charity, luckydraw
        $bitcoinWallet = BitcoinWallet::find()->all();
        $stringBitcoinWallet = '';
        foreach ($bitcoinWallet as $key => $bitcoinWallet) {
            if(!empty($stringBitcoinWallet)){
                $stringBitcoinWallet .= ';zelles(btcwallet'.$bitcoinWallet->username.')';
            }else{
                $stringBitcoinWallet .= 'zelles(btcwallet'.$bitcoinWallet->username.')';
            }  
        }
        $arrBitcoinWallet = explode(";",$stringBitcoinWallet);

        $WithdrawBitcoin = new WithdrawBitcoin;
        $Cashwithdraw = new Cashwithdraw;

        if ($Cashwithdraw->load(Yii::$app->request->post())) {

            if($balance_btc < $Cashwithdraw->amount){
                Yii::$app->getSession()->setFlash('cashwithdraw', Yii::$app->languages->getLanguage()['your_balance_not_enough_for_this_withdraw'].'!');
                return $this->render('index', [
                    'client' => $client,
                    'user' => $user,
                    'address_btc' => $address_btc,
                    'balance_btc' => $balance_btc,
                    'transction_btc' => $transction_btc,
                    'WithdrawBitcoin' => $WithdrawBitcoin,
                    'Cashwithdraw' => $Cashwithdraw,
                    'arrBitcoinWallet' => $arrBitcoinWallet,
                    'buyBtc' => $BuyBtc,
                    'listAddress' => $listAddress,
                ]);
            }

            //get amount convert
            $ConvertBitcoin = new ConvertBitcoin;
            $Currency = Currency::findOne($Cashwithdraw->currency);

            if(!empty($Currency->exchange_rate)){
                $fee = ( $Cashwithdraw->amount * $Currency->exchange_rate) * $Currency->fee / 100 ;
                $amount_convert = ( $Cashwithdraw->amount * $Currency->exchange_rate) - $fee ;
            } else {
                $exchange_rate = $ConvertBitcoin->getConvertBitcoin($Currency->currency, 'rate');
                $fee = ( $Cashwithdraw->amount * $exchange_rate) * $Currency->fee / 100 ;
                $amount_convert = ( $Cashwithdraw->amount * $exchange_rate) - $fee;
            }

            //send bitcoin to cash withdraw bitcoin wallet
            //get bitcoin wallet min amount
            $address_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_Cashwithdraw, 'min');
            //send bitcoin to SH/GH bitcoin wallet
            $sendbitcoin = $client->withdraw($user->username, $address_wallettoken, $Cashwithdraw->amount);
            if($sendbitcoin){

                Yii::$app->getSession()->setFlash('success', Yii::$app->languages->getLanguage()['your_payment_request_for_an_amount_of'].' '.$amount_convert.' '.$Currency->currency.' '.Yii::$app->languages->getLanguage()['has_been_submitted_you_will_be_notified_when_it_is_processed'].'!');
                
                $Cashwithdraw->user_id = Yii::$app->user->identity->id;
                $Cashwithdraw->currency = $Cashwithdraw->currency;
                $Cashwithdraw->bank_name = $Cashwithdraw->bank_name;
                $Cashwithdraw->recepient_name = $Cashwithdraw->recepient_name;
                $Cashwithdraw->bank_account = $Cashwithdraw->bank_account;
                $Cashwithdraw->bank_branch = $Cashwithdraw->bank_branch;
                $Cashwithdraw->swiftcode = $Cashwithdraw->swiftcode;
                $Cashwithdraw->additional_detail = $Cashwithdraw->additional_detail;
                $Cashwithdraw->amount = $Cashwithdraw->amount;
                $Cashwithdraw->fee = $fee;
                $Cashwithdraw->amount_convert = $amount_convert;
                $Cashwithdraw->status = Cashwithdraw::STATUS_PENDING;
                $Cashwithdraw->created_at = time();
                if($Cashwithdraw->save()){
                    return $this->render('index', [
                        'client' => $client,
                        'user' => $user,
                        'address_btc' => $address_btc,
                        'balance_btc' => $balance_btc,
                        'transction_btc' => $transction_btc,
                        'WithdrawBitcoin' => $WithdrawBitcoin,
                        'Cashwithdraw' => $Cashwithdraw,
                        'arrBitcoinWallet' => $arrBitcoinWallet,
                        'buyBtc' => $BuyBtc,
                        'listAddress' => $listAddress,
                    ]);
                }

            }else{
                Yii::$app->getSession()->setFlash('success', 'Your withdrawal failed!');
            }

        }

        return $this->render('index', [
            'client' => $client,
        	'user' => $user,
        	'address_btc' => $address_btc,
        	'balance_btc' => $balance_btc,
        	'transction_btc' => $transction_btc,
            'WithdrawBitcoin' => $WithdrawBitcoin,
            'Cashwithdraw' => $Cashwithdraw,
            'arrBitcoinWallet' => $arrBitcoinWallet,
            'buyBtc' => $BuyBtc,
            'listAddress' => $listAddress,
        ]);
    }

    public function actionWithdraw(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
        $amount = $_POST['amount'];
        $address = $_POST['address'];
        $account = $_POST['account']; 
		$cookies = Yii::$app->response->cookies;
		// add a new cookie to the btcaddress
		$cookies->add(new \yii\web\Cookie([
		'name' => 'btcaddress',
		'value' => $address,
		]));
 
        $Withdrawbitcoin = new Withdrawtobitcoin;
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;

        $user = User::findOne($account);

        $Withdrawbitcoin->user_id = $account;
        $Withdrawbitcoin->btcaddress = $address;
        $Withdrawbitcoin->amount = $amount;
        $Withdrawbitcoin->otp_code = rand(111111,999999);
        $Withdrawbitcoin->status = Withdrawtobitcoin::STATUS_NOACTIVE;
        $Withdrawbitcoin->created_at = time();

        if($Withdrawbitcoin->save()){
			 $connection = \Yii::$app->db;
			$connection	->createCommand()
			->delete('external_email_address', 'user_id = '.Yii::$app->user->identity->id)
			->execute(); 
			$connection->createCommand()->insert('external_email_address', [
			'user_id' => Yii::$app->user->identity->id,
			'email' => $address,
			])->execute();
            $contentmail = '<p style="margin:0">You requested to withdraw '.$amount.' BTC from PreBit. OTP code for this transaction is: <b>'.$Withdrawbitcoin->otp_code.'</b>. Please use this code to complete your action.<p>';
            $mailin->
                addTo($user->email, $user->username)-> 
                setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                setSubject('OTP request for BTC withdrawal')->
                setText('Hello '.$user->username.'!')->
                setHtml($mailtemplate->loadMailtemplate($user->username, $contentmail));
            $res = $mailin->send();
            if($res){
                return $Withdrawbitcoin->id;
            } 
        }
    }

    public function actionConfirm_otpcode(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $id_withdraw = $_POST['id_withdraw'];
        $otp_code = $_POST['otp_code'];
        //return 'Transaction completed successfully';
		
		$tokenrequest = Withdrawtobitcoin::find()->where(['id'=>$id_withdraw, 'otp_code'=>$otp_code])->one();
        if(!empty($tokenrequest)){
            $tokenrequest->status = Withdrawtobitcoin::STATUS_ACTIVE;
            $tokenrequest->save();

            $user = User::findOne($tokenrequest->user_id);
            define("IN_WALLET", true);
            $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
            $sendbitcoin = $client->withdraw($user->username, $tokenrequest->btcaddress, $tokenrequest->amount);
            if($sendbitcoin){
                return 'Transaction completed successfully';
            }
            return 'Transaction False!';
        } 
    }

    public function actionCashwithdraw(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        define("IN_WALLET", true);

        $txt_country       = $_POST['txt_country'];
        $txt_bankname      = $_POST['txt_bankname'];
        $txt_recepientname = $_POST['txt_recepientname'];
        $txt_bankaccount   = $_POST['txt_bankaccount'];
        $txt_bankbranch    = $_POST['txt_bankbranch'];
        $txt_swiftcode     = $_POST['txt_swiftcode'];
        $txt_additionaldetail = $_POST['txt_additionaldetail'];
        $txt_amount        = $_POST['txt_amount'];

        $user = User::findOne(Yii::$app->user->identity->id);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $address_btc = $client->getAddressList($user->username);
        $balance_btc = $client->getBalance($user->username);

        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;

        //get amount convert
        $ConvertBitcoin = new ConvertBitcoin;
        $Currency = Currency::findOne($txt_country);

        if(!empty($Currency->exchange_rate)){
            $fee = ( $txt_amount * $Currency->exchange_rate) * $Currency->fee / 100 ;
            $amount_convert = ( $txt_amount * $Currency->exchange_rate) - $fee ;
        } else {
            $exchange_rate = $ConvertBitcoin->getConvertBitcoin($Currency->currency, 'rate');
            $fee = ( $txt_amount * $exchange_rate) * $Currency->fee / 100 ;
            $amount_convert = ( $txt_amount * $exchange_rate) - $fee;
        }

        
        $Cashwithdraw = new Cashwithdraw;
        $Cashwithdraw->user_id = Yii::$app->user->identity->id;
        $Cashwithdraw->currency = $txt_country;
        $Cashwithdraw->bank_name = $txt_bankname;
        $Cashwithdraw->recepient_name = $txt_recepientname;
        $Cashwithdraw->bank_account = $txt_bankaccount;
        $Cashwithdraw->bank_branch = $txt_bankbranch;
        $Cashwithdraw->swiftcode = $txt_swiftcode;
        $Cashwithdraw->additional_detail = $txt_additionaldetail;
        $Cashwithdraw->amount = $txt_amount;
        $Cashwithdraw->fee = $fee;
        $Cashwithdraw->amount_convert = $amount_convert;
        $Cashwithdraw->status = Cashwithdraw::STATUS_PENDING;
        $Cashwithdraw->publish = Cashwithdraw::PUBLISH_PENDING;
        $Cashwithdraw->otpcode = rand(111111,999999);
        $Cashwithdraw->created_at = time();
        if($Cashwithdraw->save()){

            $contentmail = '<p style="margin:0">You requested to withdraw '.number_format($amount_convert, 2, '.', ',').' '.$Currency->currency.' from PreBit.</p><p>OTP code for this transaction is: <b>'.$Cashwithdraw->otpcode.'</b>. Please use this code to complete your action.<p>';
            $mailin->
                addTo($user->email, $user->username)-> 
                setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                setSubject('OTP request for cash withdrawal')->
                setText('Hello '.$user->username.'!')->
                setHtml($mailtemplate->loadMailtemplate($user->username, $contentmail));
            $res = $mailin->send();
            if($res){
                return $Cashwithdraw->id;
            } 
        }


    }

    public function actionConfirm_otpcode_cashwithdraw(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        define("IN_WALLET", true);

        $id_withdraw = $_POST['id_withdraw'];
        $otp_code = $_POST['otp_code'];

        $tokenrequest = Cashwithdraw::find()->where(['id'=>$id_withdraw, 'otpcode'=>$otp_code, 'publish' => Cashwithdraw::PUBLISH_PENDING, 'status' => Cashwithdraw::STATUS_PENDING])->one();
        if(!empty($tokenrequest)){
            $tokenrequest->publish = Cashwithdraw::PUBLISH_COMPLETED;
            $tokenrequest->save();


            $BitcoinWallet = new BitcoinWallet;
            //get bitcoin wallet min amount
            $address_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_Cashwithdraw, 'min');

            $Currency = Currency::findOne($tokenrequest->currency);
            $user = User::findOne($tokenrequest->user_id);
            
            $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

            //send bitcoin to SH/GH bitcoin wallet
            $sendbitcoin = $client->withdraw($user->username, $address_wallettoken, $tokenrequest->amount);
            if($sendbitcoin){
                return 'Your payment request for an amount of '.number_format($tokenrequest->amount_convert, 2, '.', ',').' '.$Currency->currency.' has been submitted. You will be notified when it is processed.!';
            }
        } 
    }

    public function actionSelectcountry(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $address = '';
        $countries = BuyBtc::find()->where(['country_id'=>$_POST['country'] ])->orderBy(['created_at' => SORT_DESC])->all();
        foreach ($countries as $key => $country) {
            $address .= '<li><a href="'.$country->address.'" target="_blank">'.$country->address.'</a></li>';
        }
        return $address;
    }

    public function actionSelectcurrency(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $countries = Currency::findOne($_POST['country']);
        return $countries->currency;
    }

    public function actionGetamountwithdrawconvert(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ConvertBitcoin = new ConvertBitcoin;
        $data = array();
        $Currency = Currency::findOne($_POST['currency']);
        if(!empty($Currency->exchange_rate)){
            $fee = ($_POST['amount'] * $Currency->exchange_rate) * $Currency->fee / 100 ;
            $data = ($_POST['amount'] * $Currency->exchange_rate) - $fee ;
        } else {
            $exchange_rate = $ConvertBitcoin->getConvertBitcoin($Currency->currency, 'rate');
            $fee = ($_POST['amount'] * $exchange_rate) * $Currency->fee / 100 ;
            $data = ($_POST['amount'] * $exchange_rate) -  $fee;
        }
        return $data = array($data, $fee);

    }
}
