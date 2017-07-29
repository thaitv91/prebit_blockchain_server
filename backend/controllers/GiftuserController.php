<?php

namespace backend\controllers;

use Yii;
use common\models\GiftUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GiftuserController implements the CRUD actions for GiftUser model.
 */
class GiftuserController extends BackendController
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


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => GiftUser::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = GiftUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);

        if ($model->status == GiftUser::STATUS_NOACTIVE){
            $status = GiftUser::STATUS_ACTIVE;
        }else{
            $status = GiftUser::STATUS_NOACTIVE;
        }
        $model->status = $status;
        var_dump($model->save()); exit;
        if($model->save()){
            return ['ok'];
        }
    }  
}
