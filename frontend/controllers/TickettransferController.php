<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\TicketTransfer;
use common\models\Converted;
use common\models\BitcoinWallet;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TicketTransferController implements the CRUD actions for TicketTransfer model.
 */
class TickettransferController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TicketTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('tickettransfer/index'));
        }
        $this->canUser();

        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

        $user = User::findOne(Yii::$app->user->identity->id);
        $balance = $client->getBalance($user->username);
        $buyticket = TicketTransfer::find()->where(['user_id' => $user->id, 'status' => TicketTransfer::STATUS_ACTIVE, 'mode' => TicketTransfer::MODE_BUY])->orderBy(['created_at'=>SORT_DESC])->all();
        $useticket = TicketTransfer::find()->where(['user_id' => $user->id, 'status' => TicketTransfer::STATUS_ACTIVE, 'mode' => TicketTransfer::MODE_USE])->orderBy(['created_at'=>SORT_DESC])->all();
        $usdperticket = Converted::find()->where(['object'=>'ticket'])->one();
        $bitcoinperusd = file_get_contents('https://blockchain.info/tobtc?currency=USD&value=1');
        return $this->render('index',[
            'balance'       => $balance,
            'usdperticket'  => $usdperticket,
            'bitcoinperusd' => $bitcoinperusd,
            'buyticket'     => $buyticket,
            'useticket'     => $useticket,
        ]);
    }

    public function actionBuyticket(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;
        $user_id = $_POST['user'];
        $ticket = $_POST['ticket'];
        $bitcoinamount = $_POST['bitcoinamount'];

        $user = User::findOne($user_id);
        $tickettransfer = new TicketTransfer;
        $tickettransfer->user_id  = $user->id;
        $tickettransfer->amount   = $ticket;
        $tickettransfer->bitcoin  = $bitcoinamount;
        $tickettransfer->mode     = TicketTransfer::MODE_BUY;
        $tickettransfer->otp_code = rand(111111,999999);
        $tickettransfer->status   = TicketTransfer::STATUS_NOACTIVE;
        $tickettransfer->created_at = time();
        if($tickettransfer->save()){
            $contentmail = '<p style="margin:0">You requested to buy '.$ticket.' Ticket(s). Your OTP code is: <b>'.$tickettransfer->otp_code.'</b>. Please use this code to complete your action.<p>';
            $mailin->
                addTo($user->email, $user->username)-> 
                setFrom(Yii::$app->params['supportEmail'], 'Bitway')->
                setReplyTo(Yii::$app->params['supportEmail'],'Bitway')->
                setSubject('OTP request for Ticket transfer')->
                setText('Hello '.$user->username.'!')->
                setHtml($mailtemplate->loadMailtemplate($user->username, $contentmail));
            $res = $mailin->send();
            return $tickettransfer->id;
        }
    }

    public function actionConfirm_otpcode(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        $id_ticketrequest = $_POST['id_ticketrequest'];
        $otp_code = $_POST['otp_code'];
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

        $tickettransfer = TicketTransfer::find()->where(['id'=>$id_ticketrequest, 'otp_code'=>$otp_code])->one();
        if(empty($tickettransfer)){
            return 'error';
        } else {
            $user = User::findOne($tickettransfer->user_id);
            $BitcoinWallet = new BitcoinWallet;
            //get bitcoin wallet min amount
            $address_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_Ticketwallet, 'min');
            $sendbitcoin = $client->withdraw($user->username, $address_wallettoken, $tickettransfer->bitcoin);
            if($sendbitcoin){
                $user->ticket = $user->ticket + $tickettransfer->amount;
                if($user->save()){
                    $tickettransfer->status = TicketTransfer::STATUS_ACTIVE;
                    $tickettransfer->save();
                }
            }
        }
    }


    protected function findModel($id)
    {
        if (($model = TicketTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
