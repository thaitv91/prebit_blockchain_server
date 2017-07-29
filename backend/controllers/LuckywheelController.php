<?php

namespace backend\controllers;

use Yii;
use common\models\LuckyWheel;
use common\models\ListGift;
use common\models\GiftLuckywheel;
use common\models\SpinWheel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LuckywheelController implements the CRUD actions for LuckyWheel model.
 */
class LuckywheelController extends BackendController
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
     * Lists all LuckyWheel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => LuckyWheel::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LuckyWheel model.
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
     * Creates a new LuckyWheel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LuckyWheel();
        $ListGifts = ListGift::find()->where(['publish'=>ListGift::PUBLISH_ACTIVE])->all();
        $listgift = array();
        foreach ($ListGifts as $key => $value) {
            $listgift[$value->id] = $value->name;
        }

        if ($model->load(Yii::$app->request->post())) {
           // $gifts = ;

            if(!empty($_POST['listgift'])){
                $datestart=date_create($model->start);
                $start = strtotime(date_format($datestart,"m/d/Y"));
                $datefinish=date_create($model->finish);
                $finish = strtotime(date_format($datefinish,"m/d/Y"));
                $model->name = $model->name;
                $model->start = $start;
                $model->finish = $finish;
                $model->publish = LuckyWheel::PUBLISH_NOACTIVE;
                $model->status = LuckyWheel::STATUS_NOACTIVE;
                $model->created_at = time();
                if($model->save()){
                    foreach ($_POST['listgift'] as $key => $value) {
                        $gift_luckywheel = new GiftLuckywheel;
                        $gift_luckywheel->id_gift = $value;
                        $gift_luckywheel->id_luckywheel = $model->id;
                        $gift_luckywheel->save();
                    }
                    return $this->redirect(['createspin', 'id' => $model->id]);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Select gift for Lucky wheel!');
                return $this->render('create', [
                    'model' => $model,
                    'listgift' => $listgift,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'listgift' => $listgift,
            ]);
        }
    }

    public function actionCreatespin($id){
        $gift_luckywheel = GiftLuckywheel::find()->where(['id_luckywheel' => $id])->all();
        $spinwheel = SpinWheel::find()->where(['id_luckywheel'=>$id])->orderBy(['number_order'=>SORT_ASC])->all();
        return $this->render('createspin', [
            'model' => $this->findModel($id),
            'gift_luckywheel' => $gift_luckywheel,
            'spinwheel' => $spinwheel,
            'id' => $id,
        ]);
    }

    /**
     * Updates an existing LuckyWheel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ListGifts = ListGift::find()->where(['publish'=>ListGift::PUBLISH_ACTIVE])->all();
        $GiftLuckywheel = GiftLuckywheel::find()->where(['id_luckywheel' => $id])->all();
        $listgiftSelected = array();
        foreach ($GiftLuckywheel as $keys => $val) {
            $listgiftSelected[] = $val->id_gift;
        }
        $listgift = array();
        foreach ($ListGifts as $key => $value) {
            $listgift[$value->id] = $value->name;
        }

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($_POST['listgift'])){
                $datestart=date_create($model->start);
                $start = strtotime(date_format($datestart,"m/d/Y"));
                $datefinish=date_create($model->finish);
                $finish = strtotime(date_format($datefinish,"m/d/Y"));
                $model->name = $model->name;
                $model->start = $start;
                $model->finish = $finish;
                $model->created_at = time();
                if($model->save()){
                    $delete = GiftLuckywheel::deleteAll('id_luckywheel = '.$id);
                    foreach ($_POST['listgift'] as $key => $value) {
                        $gift_luckywheel = new GiftLuckywheel;
                        $gift_luckywheel->id_gift = $value;
                        $gift_luckywheel->id_luckywheel = $model->id;
                        $gift_luckywheel->save();
                    }
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Select gift for Lucky wheel!');
                return $this->render('update', [
                    'model' => $model,
                    'listgift' => $listgift,
                    'listgiftSelected' => $listgiftSelected,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'listgift' => $listgift,
                'listgiftSelected' => $listgiftSelected,
            ]);
        }
    }

    /**
     * Deletes an existing LuckyWheel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $deleteSpinWheel = SpinWheel::deleteAll('id_luckywheel = '.$id);
        $deleteGiftLuckywheel = GiftLuckywheel::deleteAll('id_luckywheel = '.$id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the LuckyWheel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LuckyWheel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuckyWheel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdategiftquatity(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $gift_luckywheel = GiftLuckywheel::find()->where(['id'=>$value['id']])->one();
            $gift_luckywheel->quatity = $value['quatity'];
            $gift_luckywheel->save();
        }
    }

    public function actionUpdatespinwheel(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST['id'];
        $string = $_POST['spinwheel'];
        $arr =  json_decode($string, true);
        $arr_spin = array();
        foreach ($arr as $key => $value) {
            $arr_spin[] = $value['id'];
        }
        $delete = SpinWheel::deleteAll('id_luckywheel = '.$id);

        foreach ($arr_spin as $keys => $val) {
            $model = new SpinWheel;
            $model->id_gift = $val;
            $model->id_luckywheel = $id;
            $model->number_order = $keys +1;
            $model->save();
        }

    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if ($model->publish == LuckyWheel::PUBLISH_ACTIVE){
            $publish = LuckyWheel::PUBLISH_NOACTIVE;
        }else{
            $publish = LuckyWheel::PUBLISH_ACTIVE;
        }
            
        $model->publish = $publish;
        if($model->save()){
            return ['ok'];
        }
    }
}
