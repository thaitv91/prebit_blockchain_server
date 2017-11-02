<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\GhTransfer;
use backend\models\GhTransferFilter;
use common\extensions\Client;
use common\models\BitcoinWallet;

use common\models\User;
use frontend\models\WithdrawBitcoin;
use common\models\Withdrawtobitcoin;
use common\models\Cashwithdraw;
use common\models\Currency;
use common\models\BuyBtc;
use common\extensions\jsonRPCClient;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use common\extensions\ConvertBitcoin;
use yii\web\NotFoundHttpException;
use yii\db\Query;

/**
 * Site controller
 */
class GhmanagementController extends BackendController
{
    public function actionIndex()
    {

        define("IN_WALLET", true);
        $model_main = new GhTransfer;


        $ghtransferfilter = new GhTransferFilter;
        $query = GhTransfer::find();
        if ($ghtransferfilter->load(Yii::$app->request->get())) {
            $query->where(['>', 'id', 0])->orderBy(['created_at' => SORT_DESC]);
            if (!empty($ghtransferfilter->username)) {
                $query->andWhere(["IN", "user_id", $ghtransferfilter->getUser($ghtransferfilter->username)]);
            }
            if (!empty($ghtransferfilter->status)) {
                if ($ghtransferfilter->status == GhTransferFilter::STATUS_PENDING) {
                    $query->andWhere(['publish' => GhTransfer::PUBLISH_NOACTIVE]);
                }
                if ($ghtransferfilter->status == GhTransferFilter::STATUS_COMPLETED) {
                    $query->andWhere(['publish' => GhTransfer::PUBLISH_ACTIVE]);
                }
            }
            if (!empty($ghtransferfilter->fromday)) {
                $date = date_create($ghtransferfilter->fromday);
                $datefrom = strtotime(date_format($date, "m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if (!empty($ghtransferfilter->today)) {
                $date = date_create($ghtransferfilter->today);
                $dateto = strtotime(date_format($date, "m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }


        } else {
            $query->where(['>', 'id', 0])->orderBy(['created_at' => SORT_DESC]);

        }
        $query->andWhere(["IN", "user_id", $ghtransferfilter->getUserNotjap()]);
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
            'ghtransferfilter' => $ghtransferfilter,
        ]);
    }

    public function actionApprove()
    {
        define("IN_WALLET", true);
        $bitcoin_rate = file_get_contents('https://blockchain.info/tobtc?currency=USD&value=1');
        $address = $_GET['bitid'];
        $id = $_GET['id'];
        $gh = GhTransfer::findOne($id);
        $BitcoinWallet = new BitcoinWallet;
        $amount = $gh->amount * $bitcoin_rate;
        if (!empty($gh)) {
            //get address bitcoin user gethelp
            $user = User::findOne($gh->user_id);
            $addressbitcoin_user = $address;
            //get total balance bitcoin system wallet 
            $account_wallettoken = $BitcoinWallet->findBalancebitcoin(BitcoinWallet::TYPE_ShAndGhwallet);
            
            if ($account_wallettoken > $amount) {
                $transfer_bitcoin = $BitcoinWallet->transfersBitcoin(BitcoinWallet::TYPE_ShAndGhwallet, $addressbitcoin_user, $amount);
                $gh->publish = GhTransfer::PUBLISH_ACTIVE;
                $gh->save();
                Yii::$app->getSession()->setFlash('success', 'Approve successfully, Waiting for Tranfer Bitcoin!');
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('error', 'Your balance not enough!');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
}

?>