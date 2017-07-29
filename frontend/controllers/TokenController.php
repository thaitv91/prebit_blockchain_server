<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Converted;
use common\models\TokenRequest;
use common\models\BitcoinWallet;
use common\models\ShTransfer;
use common\models\GhTransfer;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use frontend\models\TransferToken;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TokenController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('token/index'));
        }
        $this->canUser();

        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        
    	$bitpertoken = Converted::find()->where(['object'=>'token'])->one();
        $user = User::findOne(Yii::$app->user->identity->id);
    	$model = new TokenRequest();
        $TransferToken = new TransferToken();
        $BitcoinWallet = new BitcoinWallet;
        $balance = $client->getBalance($user->username);

        //get token can transfer
        //token gift wheren register
        $tokenregister = Converted::find()->where(['object'=>'tokenregister'])->one();    
        //total token sh,gh
        $tokensh = 0;
        $tokengh = 0;
        $shtransfers = ShTransfer::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        if(!empty($shtransfers)){
            foreach ($shtransfers as $key => $shtransfer) {
                $tokenforsh = $shtransfer->getTokenamount($shtransfer->amount);
                $tokensh += $tokenforsh;
            }
        }
        $ghtransfers = GhTransfer::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        if(!empty($ghtransfers)){
            foreach ($ghtransfers as $key => $ghtransfer) {
                $tokenforgh = $ghtransfer->getTokenamount($ghtransfer->amount, $ghtransfer->status);
                $tokengh += $tokenforgh;
            }
        }
        //total amount token sh,gh
        $totalshgh =  $tokensh + $tokengh;

        //số token đã dùng để sh,gh nhỏ hơn số token được tặng
        if($totalshgh < $tokenregister->value){
            //token can transfer
            $token_cantransfer = $user->token - ($tokenregister->value - $totalshgh);
        } else {
            $token_cantransfer = $user->token;
        }

        

        $amount = Yii::$app->user->identity->token;
        // buy token
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($balance < $model->bitcoin){
                Yii::$app->getSession()->setFlash('alert_token', Yii::$app->languages->getLanguage()['your_bitcoin_wallet_balance_is_not_enough'].'!');
                return $this->redirect(['index']);
            }

        	$model->user_id = Yii::$app->user->identity->id;
        	$model->bitcoin = $model->bitcoin;
        	$model->amount = $model->amount;
            $model->balance = $amount + $model->amount;
        	$model->reciever = $model->reciever;
        	$model->mode = TokenRequest::MODE_BUY;
        	$model->publish = TokenRequest::PUB_ACTIVE;
        	$model->created_at = time();

            //get bitcoin wallet min amount
            $address_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_Tokenwallet, 'min');

        	if($model->save()){
                $user->token = $user->token + $model->amount;
                $user->save();

                //transaction bitcoin

                $sendbitcoin = $client->withdraw($user->username, $address_wallettoken, $model->bitcoin);
                if($sendbitcoin){
                    Yii::$app->getSession()->setFlash('alert_token', Yii::$app->languages->getLanguage()['your_balance_was_added'].' '.$model->amount.' Token(s)!');
                }else{
                    Yii::$app->getSession()->setFlash('alert_token', 'Transaction error_reporting()!');
                }
        		return $this->redirect(['index']);
        	}
        }

        // transfer token
        if ($TransferToken->load(Yii::$app->request->post()) && $TransferToken->validate()){
            $reciever = User::find()->where(['username'=>$TransferToken->reciever])->one();

            $TokenRequest = new TokenRequest;
            $TokenRequest->user_id = Yii::$app->user->identity->id;
            $TokenRequest->amount = $TransferToken->amount_token;
            $TokenRequest->balance = $amount - $TransferToken->amount_token;
            $TokenRequest->reciever = $reciever->id;
            $TokenRequest->mode = TokenRequest::MODE_TRANS;
            $TokenRequest->publish = TokenRequest::PUB_ACTIVE;
            $TokenRequest->created_at = time();
            if($TokenRequest->save()){
                $reciever->token = $reciever->token + $TransferToken->amount_token;
                $reciever->save();
                
                $user->token = $user->token - $TransferToken->amount_token;
                $user->save();
                Yii::$app->getSession()->setFlash('alert_token', 'Transfered '.$TransferToken->amount_token.' token(s) to '.$TokenRequest->getUser($reciever->id)->username.'!');
                return $this->redirect(['index']);
            }    
        }

        $query = TokenRequest::find()->where(['OR', ['user_id'=>Yii::$app->user->identity->id], ['reciever'=>Yii::$app->user->identity->id]])->andWhere(['publish'=>TokenRequest::PUB_ACTIVE])->orderBy(['created_at'=>SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);
        return $this->render('index', ['model'=>$model, 'TransferToken' => $TransferToken, 'balance' => $balance, 'bitpertoken'=>$bitpertoken->value, 'dataProvider' => $dataProvider, 'token_cantransfer' => $token_cantransfer]);
    }

    public function actionCheckissetusername(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $reciever = $_POST['reciever'];
        $user = User::find()->where(['username'=>$reciever])->one();
        if(empty($user)){
            return 'none';
        }
    }

    public function actionInserttokentransfer(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;
        $reciever = $_POST['reciever'];
        $user = $_POST['user'];
        $amounttoken = $_POST['amounttoken'];

        $reciever = User::find()->where(['username'=>$reciever])->one();
        $usersender = User::findOne(Yii::$app->user->identity->id);
        $amount = Yii::$app->user->identity->token;
        $TokenRequest = new TokenRequest;
        $TokenRequest->user_id = $user;
        $TokenRequest->amount = $amounttoken;
        $TokenRequest->balance = $amount - $amounttoken;
        $TokenRequest->reciever = $reciever->id;
        $TokenRequest->otp_code = rand(111111,999999);
        $TokenRequest->mode = TokenRequest::MODE_TRANS;
        $TokenRequest->publish = TokenRequest::PUB_NOACTIVE;
        $TokenRequest->created_at = time();
        if($TokenRequest->save()){
            // $reciever->token = $reciever->token + $amounttoken;
            // $reciever->save();
            
            // $usersender->token = $usersender->token - $amounttoken;
            // $usersender->save();
            //send mail register
            $contentmail = '<p style="margin:0">You requested to transfer '.$amounttoken.' Token(s) to '.$TokenRequest->getUser($reciever->id)->username.'. Your OTP code is: <b>'.$TokenRequest->otp_code.'</b>. Please use this code to complete your action.<p>';
            $mailin->
                addTo($usersender->email, $usersender->username)-> 
                setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                setSubject('OTP request for Token transfer')->
                setText('Hello '.$usersender->username.'!')->
                setHtml($mailtemplate->loadMailtemplate($usersender->username, $contentmail));
            $res = $mailin->send();
            return $TokenRequest->id;
        }    
        
    }

    public function actionConfirm_otpcode(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $id_tokenrequest = $_POST['id_tokenrequest'];
        $otp_code = $_POST['otp_code'];

        $tokenrequest = TokenRequest::find()->where(['id'=>$id_tokenrequest, 'otp_code'=>$otp_code])->one();
        if(empty($tokenrequest)){
            return 'error';
        } else {
            $tokenrequest->publish = TokenRequest::PUB_ACTIVE;
            $tokenrequest->save();

            $reciever = User::findOne($tokenrequest->reciever);
            $reciever->token = $reciever->token + $tokenrequest->amount;
            $reciever->save();
            
            $usersender = User::findOne($tokenrequest->user_id);
            $usersender->token = $usersender->token - $tokenrequest->amount;
            $usersender->save();
        }
    }
}
