<?php

namespace backend\controllers;

use Yii;
use common\models\BlockList;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashwithdrawController implements the CRUD actions for Cashwithdraw model.
 */
class BlockmanagementController extends BackendController
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

    /**
     * Lists all Cashwithdraw models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userblock = User::find()->where(['block'=>User::BLOCK_ACTIVE])->orderBy(['timeblock'=>SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $userblock,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Cashwithdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cashwithdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cashwithdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($_POST['act'] == "close")
            $publish = Cashwithdraw::STATUS_PEDDING;
        else
            $publish = Cashwithdraw::STATUS_COMPLETED;

        $model = $this->findModel($_POST['id']);
        $model->status = $publish;
        if($model->save()){
            return ['ok'];
        }
    
    }
}
