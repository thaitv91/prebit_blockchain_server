<?php
namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\ShTransfer;
use common\models\ShWithdraw;
use common\models\User;
use common\models\BitcoinWallet;
use backend\models\ShTransferFilter;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\Mailin;
use common\extensions\MailTemplate;


/**
 * Site controller
 */
class ShmanagementController extends BackendController
{
	public function actionIndex()
    {
		/* $ip   = $_SERVER['REMOTE_ADDR'];
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
		$country=$details->geoplugin_countryCode;
		if($country==="JP"){
		throw new NotFoundHttpException('The requested page does not exist.');
		} */
        $shtransferfilter = new ShTransferFilter;
        $shtransfer = new ShTransfer;
        //check shtransfer completed
        $shtransfer->checkallShtransfer;

        $query = ShTransfer::find();
		
        if ($shtransferfilter->load(Yii::$app->request->get())) {
            $query->where(['>=', 'amount', 0])->orderBy(['created_at'=>SORT_DESC]);
            if(!empty($shtransferfilter->username)){
                $query->andWhere(["IN", "user_id", $shtransferfilter->getUser($shtransferfilter->username)]);
            }
            if(!empty($shtransferfilter->status)){
                if($shtransferfilter->status == ShTransferFilter::STATUS_CANCELED){
                    $query->andWhere(["publish" => ShTransfer::PUBLISH_NOACTIVE]);
                }
                if($shtransferfilter->status == ShTransferFilter::STATUS_GOING){
                    $query->andWhere(["<=", "status", ShTransfer::STATUS_WITHDRAW])->andWhere(["publish" => ShTransfer::PUBLISH_ACTIVE]);
                }
                if($shtransferfilter->status == ShTransferFilter::STATUS_MATURITY){
                    $query->andWhere(["status" => ShTransfer::STATUS_CAPITAL_WITHDRAW])->andWhere(["publish" => ShTransfer::PUBLISH_ACTIVE]);
                }
                if($shtransferfilter->status == ShTransferFilter::STATUS_COMPLETED){
                    $query->andWhere(["status" => ShTransfer::STATUS_COMPLETED])->andWhere(["publish" => ShTransfer::PUBLISH_ACTIVE]);
                }   
            }
            if(!empty($shtransferfilter->fromday)){
                $date=date_create($shtransferfilter->fromday);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($shtransferfilter->today)){
                $date=date_create($shtransferfilter->today);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }
            //var_dump($query); exit;
        }else{
            $query->where(['>=', 'amount', 0])->orderBy(['created_at'=>SORT_DESC]);
			
        }

        $query->andWhere(["IN", "user_id", $shtransferfilter->getUserNotjap()]);

        $model = $query->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'shtransferfilter' => $shtransferfilter,
        ]);
    }

    public function actionView($id)
    {
        $shtransfer = ShTransfer::find()->all();
        $sh_withdraw = ShWithdraw::find()->where(['id_shtransfer' => $id])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('view', [
            'model' => $this->findModel($id), 
            'shtransfer' => $shtransfer,
            'sh_withdraw' => $sh_withdraw,
        ]);
    }

    public function actionCancel($id)
    {
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $BitcoinWallet = new BitcoinWallet;
        $shtransfer = ShTransfer::findOne($id);
        
        $user = User::findOne($shtransfer->user_id);
        //get account bitcoin wallet max amount
        $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_ShAndGhwallet, 'max');
        //get balance account_wallettoken
        $balance_wallettoken = $client->getBalance($account_wallettoken);

        if($balance_wallettoken <= $shtransfer->amount){
            Yii::$app->getSession()->setFlash('success_shmanager', 'This SendHelp can not be canceled!');
            return $this->redirect(['shmanagement/index']);
        }else{
            //get address username
            $address_wallettoken = $client->getAddress($user->username);
            //send bitcoin to SH/GH bitcoin wallet
            $sendbitcoin = $client->withdraw($account_wallettoken, $address_wallettoken, $shtransfer->amount);
            
            if($sendbitcoin){
                $shtransfer->publish = ShTransfer::PUBLISH_NOACTIVE;
                $shtransfer->inc_days = time();
                $shtransfer->save();

                //send mail
                $mailin->
                    addTo($user->email, $user->username)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'Bitway')->
                    setReplyTo(Yii::$app->params['supportEmail'],'Bitway')->
                    setSubject('Your sendhelp was canceled')->
                    setText('Hello '.$user->username.'!')->
                    setHtml('<p>Your sendhelp was canceled, the money has been transferred to your Bitway wallet</p>');
                $res = $mailin->send();


                Yii::$app->getSession()->setFlash('success_shmanager', 'SendHelp was canceled!');
            } else {
                Yii::$app->getSession()->setFlash('success_shmanager', 'Can not canceled!');
            }
            
            return $this->redirect(['shmanagement/index']);
        }
        
    }

    protected function findModel($id)
    {
        if (($model = ShTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
?>