<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DownlinetreeController extends FrontendController
{
    public function actionIndex()
    {
    	if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('downlinetree/index'));
        }
        $this->canUser();

    	$id = Yii::$app->user->identity->id;
    	$user = User::findOne($id);
        $data = array();
        $count = $user->getDownlinetreemember($id, $data);
        return $this->render('index', ['user'=>$user, 'count' => $count]);
    }

    
}


