<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\db\Query;
use yii\data\Pagination;
use common\models\User;
use common\models\ShTransfer;
use common\models\GhTransfer;
use common\models\TokenRequest;


class AjaxController extends BackendController {

    public function actionChecksector() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = 'ádadadsa';
        // $user = User::findOne($_POST['user_id']);
        // $job = Job::find()->where(['IN', 'sector_id', $user->sector])->all();
        // $data = [];
        // if (!empty($job)) {
        //     foreach ($job as $value) {
        //         $data[] = ['id' => $value->id, 'name' => $value->name];
        //     }
        // }
        return $data;
    }

    public function actionUserstatistical(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));

        //user register
        $user = User::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->count();
        //user sh
        $shtransfer = ShTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->groupBy(['user_id'])->count();
        //user sh
        $ghtransfer = GhTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->groupBy(['user_id'])->count();

        return $string_result = array($user,$shtransfer,$ghtransfer);
    }

    public function actionTotalamountstatistical(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));

        $amountshtransfer = ShTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('amount');

        $amountghtransfer = GhTransfer::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('amount');

        $amounttoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->sum('bitcoin');

        return $string_result = array(number_format($amountshtransfer,8),number_format($amountghtransfer,8),number_format($amounttoken, 8));
    }

    public function actionTotaltoken(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));
        //total buy token
        $amountbuytoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->andWhere(['mode'=>TokenRequest::MODE_BUY])->sum('amount');
        //total transfer token
        $amounttransfertoken = TokenRequest::find()->where(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->andWhere(['mode'=>TokenRequest::MODE_TRANS])->sum('amount');

        return $string_result = array($amountbuytoken,$amounttransfertoken);
    }

    public function actionTotalghbalance(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));
        //total gh balance
        $totalghbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('wallet');
        //total manager bonus
        $totalmanagerbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('manager_bonus');
        //total referral bonus
        $totalreferralbalance = User::find()->where(['status'=>User::STATUS_ACTIVE])->sum('referral_bonus');

        return $string_result = array(number_format($totalghbalance,2), number_format($totalmanagerbalance + $totalreferralbalance,2));

    }

}
