<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use common\models\Account;
use common\models\TokenGift;
use common\models\User;
use common\models\ShTransfer;
use common\models\GhTransfer;
use common\models\TokenRequest;
use common\models\BitcoinWallet;
use backend\models\ForgetPassword;
use backend\models\ChangePassword;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'forgetpassword', 'changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->redirect('/user/index');
        // $tokengift = new TokenGift;
        // $tokengift->sendtokengift();
        // $modelusser = new User;
        // $modelusser->checkblockuser();

        // $cv_dateto = strtotime(date('m/d/Y 00:00', time()));
        // $cv_datefrom = strtotime(date('m/d/Y 23:59', time()));

        // //user register
        // $user = User::find()->where(['status'=>User::STATUS_ACTIVE])->andWhere(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->count();
        // //total user actived
        // $total_userregister = User::find()->where(['status'=>User::STATUS_ACTIVE])->count();
        // //user sh
        // $shtransfer = ShTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->groupBy(['user_id'])->count();
        // //user sh
        // $ghtransfer = GhTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->groupBy(['user_id'])->count();
        // //Total amount sh 
        // $amountshtransfer = ShTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('amount');
        // //Total amount gh 
        // $amountghtransfer = GhTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('amount');
        // //Total amount buy token 
        // $amounttoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('bitcoin');
        // //total buy token
        // $amountbuytoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->andWhere(['mode'=>TokenRequest::MODE_BUY])->sum('amount');
        // //total transfer token
        // $amounttransfertoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->andWhere(['mode'=>TokenRequest::MODE_TRANS])->sum('amount');
        // //total gh balance
        // $totalghbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('wallet');
        // //total manager bonus
        // $totalmanagerbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('manager_bonus');
        // //total referral bonus
        // $totalreferralbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('referral_bonus');

        // //get account sh bitcoin wallet
        // define("IN_WALLET", true);
        // $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        // $BitcoinWallet = BitcoinWallet::find()->where(['type'=>BitcoinWallet::TYPE_ShAndGhwallet])->orderBy(['created_at'=> SORT_DESC])->all();
        // $bitcoinwallet_balance = 0;
        // foreach ($BitcoinWallet as  $bitcoinwallet) {
        //     $bitcoinwallet_balance += $client->getBalance('btcwallet'.$bitcoinwallet->username);
        // }


        // return $this->render('index',[
        //     'user' => $user,
        //     'shtransfer' => $shtransfer,
        //     'ghtransfer' => $ghtransfer,
        //     'amountshtransfer' => $amountshtransfer,
        //     'amountghtransfer' => $amountghtransfer,
        //     'amounttoken' => $amounttoken,
        //     'amountbuytoken' => $amountbuytoken,
        //     'amounttransfertoken' => $amounttransfertoken,
        //     'totalghbalance' => $totalghbalance,
        //     'totalmanagerbonusbalance' => $totalmanagerbalance + $totalreferralbalance, 
        //     'bitcoinwallet_balance' => $bitcoinwallet_balance,
        //     'total_userregister' => $total_userregister,
        // ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {        
            return $this->goBack();
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionForgetpassword() {
        $this->layout = 'login';
        $model = new ForgetPassword();
        if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        } else{
            return $this->render('forgetpassword', ['model' => $model]);
        }

    }

}
