<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;
use yii\db\Collection;
use common\models\User;
use common\models\BlockList;

class FrontendController extends Controller {

    // public function init() {
    //     if (\Yii::$app->user->isGuest)
    //         $this->redirect('/site/login');
    // }

//    public function behaviors() {
//        $behaviors['access'] = [
//            'class' => AccessControl::className(),
//            'rules' => [
//                [
//                    'allow' => true,
//                    'roles' => ['@'],
//                    'matchCallback' => function ($rule, $action) {
//                $action = Yii::$app->controller->action->id;
//                $controller = Yii::$app->controller->id;
//                $route = "/$controller/$action";
//                $route1 = "/$controller/*";
//                $post = Yii::$app->request->post();
//                if (\Yii::$app->user->can($route)) {
//                    return true;
//                } else {
//                    throw new NotFoundHttpException('this page not found.');
//                }
//            }
//                ],
//            ],
//        ];
//        $behaviors['verbs'] = [
//            'class' => VerbFilter::className(),
//            'actions' => [
//                'delete' => ['post'],
//            ],
//        ];
//        return $behaviors;
//    }
//    public function actions() {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }
    protected function request($key) {
        if (Yii::$app->session->hasFlash($key))
            return $this->redirect(['index', 'page' => Yii::$app->session->getFlash($key)]);
        else
            return $this->redirect(['index']);
    }

    protected function canUser() {
        //check block account
        $user = User::findOne(Yii::$app->user->identity->id);
        if($user->block == BlockList::BLOCK_ACTIVE){
            return $this->redirect(['site/unblock']);
        }
    }

}
