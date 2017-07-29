<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Newsmanagement;

class NewsmanagementController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('newsmanagement/index'));
        }
        $this->canUser();

    	$model = Newsmanagement::find()->where(['publish' => Newsmanagement::PUBLISH_ACTIVE])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index',[
        	'model' => $model,
    	]);
    }
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('newsmanagement/view/'.$id));
        }
        $this->canUser();

    	$model = Newsmanagement::find()->all();
        return $this->render('view',[
        	'model' => $this->findModel($id),
    	]);
    }
    protected function findModel($id)
    {
        if (($model = Newsmanagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
