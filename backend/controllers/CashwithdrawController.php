<?php

namespace backend\controllers;

use Yii;
use common\models\Cashwithdraw;
use common\models\Currency;
use common\models\User;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use backend\models\CashwithdrawFilter;
use backend\models\PublishCashwithdraw;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashwithdrawController implements the CRUD actions for Cashwithdraw model.
 */
class CashwithdrawController extends BackendController
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
        $cashwithdrawFilter = new CashwithdrawFilter;
        $query = Cashwithdraw::find();

        if ($cashwithdrawFilter->load(Yii::$app->request->get())) {
            $query->where(['>', 'id', 0])->orderBy(['created_at'=>SORT_DESC]);
            if(!empty($cashwithdrawFilter->username)){
                $query->andWhere(["IN", "user_id", $cashwithdrawFilter->getUser($cashwithdrawFilter->username)]);
            }
            if(!empty($cashwithdrawFilter->status)){
                if($cashwithdrawFilter->status == Cashwithdraw::STATUS_PENDING){
                    $query->andWhere([">", "created_at", time() - 1800]);
                }
                if($cashwithdrawFilter->status == Cashwithdraw::STATUS_COMPLETED){
                    $query->andWhere(["<", "created_at", time() - 1800]);
                }  
            }
            if(!empty($cashwithdrawFilter->fromday)){
                $date=date_create($cashwithdrawFilter->fromday);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($cashwithdrawFilter->today)){
                $date=date_create($cashwithdrawFilter->today);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }


        } else{
            $query->where(['>', 'id', 0])->orderBy(['created_at'=>SORT_DESC]);
        }

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
            'cashwithdrawFilter' => $cashwithdrawFilter,
        ]);
    }

    /**
     * Displays a single Cashwithdraw model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cashwithdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cashwithdraw();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cashwithdraw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cashwithdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;
        $model = PublishCashwithdraw::findOne($_POST['id']);

        if ($model->status == Cashwithdraw::STATUS_PENDING){
            $status = Cashwithdraw::STATUS_COMPLETED;
        } else {
            $status = Cashwithdraw::STATUS_PENDING;
        }
        $model->status = $status;
        if($model->save()){
            if($model->status == PublishCashwithdraw::STATUS_COMPLETED){
                $Currency = Currency::findOne($model->currency);
                $user = User::findOne($model->user_id);
                //send mail register
                $contentmail = '<p style="margin:0">Your payment request for an amount of '.number_format($model->amount_convert, 2, '.', ',').' '.$Currency->currency.' has been processed</p><p style="margin:0">Your will receive your money soon.</p>';
                $mailin->
                    addTo($user->email, $user->username)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'Bitway')->
                    setReplyTo(Yii::$app->params['supportEmail'],'Bitway')->
                    setSubject('Your payment request on Bitway has been processed')->
                    setText('Hello '.$user->username.'!')->
                    setHtml($mailtemplate->loadMailtemplate($user->username, $contentmail));
                $res = $mailin->send();
            }
            return ['ok'];
        }
    
    }
}
