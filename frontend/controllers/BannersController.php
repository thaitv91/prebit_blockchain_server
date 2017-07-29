<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
/**
 * UserController implements the CRUD actions for Users model.
 */
class BannersController extends FrontendController
{
    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
}
