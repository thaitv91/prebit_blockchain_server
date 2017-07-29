<?php

namespace frontend\controllers;

use Yii;
use common\models\TokenRequest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TicketController extends FrontendController
{
	public function actionIndex()
    {
        return $this->render('index');
    }
}
