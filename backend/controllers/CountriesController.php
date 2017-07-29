<?php

namespace backend\controllers;

use Yii;
use common\models\Countries;
use common\models\States;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountriesController implements the CRUD actions for Countries model.
 */
class CountriesController extends BackendController
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
     * Lists all Countries models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!empty($_GET['id']))
            $id = $_GET['id'];
        else
            $id = NULL;
        $query = Countries::find();
        $model = Countries::find()->all();
        $items = [];
        foreach ($model as $value)
        {
            $items[] = ['id' => $value->id, 'name' => $value->name, 'country_code' => $value->country_code, 'state' => '-', 'postcode' => '-', 'create_state' => 1, 'publish' => $value->publish];
            foreach ($value->states as $states)
            {
                $items[] = ['id' => $states->id, 'name' => '', 'country_code' => '-', 'state' => $states->name, 'postcode' =>  $states->postcode, 'create_state' => 2, 'publish' => $states->publish];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 50
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id, 'query' => $model]);
    }

    /**
     * Displays a single Countries model.
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
     * Creates a new Countries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Countries();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->name = $model->name;
            $model->country_code = $model->country_code;
            $model->language = 'en';
            $model->publish  = Countries::PUBLISH_ACTIVE;
            $model->created_at = time();
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Countries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!empty($_GET['id']))
            $id = $_GET['id'];
        else
            $id = NULL;
        $query = Countries::find();
        $country = Countries::find()->all();
        $items = [];
        foreach ($country as $value)
        {
            $items[] = ['id' => $value->id, 'name' => $value->name, 'country_code' => $value->country_code, 'state' => '-', 'postcode' => '-', 'create_state' => 1, 'publish' => $value->publish];
            foreach ($value->states as $states)
            {
                
                $items[] = ['id' => $states->id, 'name' => '', 'country_code' => '-', 'state' => $states->name, 'postcode' =>  $states->postcode, 'create_state' => 2, 'publish' => $states->publish];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing Countries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        States::deleteAll('country_id = :id', [':id' => $id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Countries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($_POST['type'] == 'country')
        {
            if ($_POST['act'] == "close")
                $publish = Countries::PUBLISH_NONEACTIVE;
            else
                $publish = Countries::PUBLISH_ACTIVE;

            $model = $this->findModel($_POST['id']);
            $model->publish = $publish;
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }
        else
        {
            if ($_POST['act'] == "close")
                $publish = States::PUBLISH_NONEACTIVE;
            else
                $publish = States::PUBLISH_ACTIVE;
            $model = States::findOne($_POST['id']);
            $model->publish = $publish;
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }
    }
}
