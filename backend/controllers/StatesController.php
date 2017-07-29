<?php

namespace backend\controllers;

use Yii;
use common\models\States;
use common\models\Countries;
use common\models\Cities;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatesController implements the CRUD actions for states model.
 */
class StatesController extends BackendController
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
     * Lists all states models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => States::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        if (!empty($_GET['id']))
            $id = $_GET['id'];
        else
            $id = NULL;
        $model = States::findOne($id);
        $items = [];
        $items[] = ['id' => $model->id, 'name' => $model->name, 'city' => '-','code' => $model->postcode, 'create_city' => 1, 'publish' => $model->publish];
        foreach ($model->cities as $city)
        {
            $items[] = ['id' => $city->id, 'name' => '', 'city' => $city->name, 'code' => $city->city_code, 'create_city' => 2, 'publish' => $city->publish];
        }

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 50
            ],
        ]);
        return $this->render('view', ['dataProvider' => $dataProvider, 'id' => $id, 'model' => $model]);
    }

    public function actionCreate()
    {
        $model = new States();
        $country = Countries::find()->all();
        if ($model->load(Yii::$app->request->post())) {

            $model->name = $model->name;
            $model->country_id = $model->country_id;
            $model->postcode = $model->postcode;
            $model->publish  = States::PUBLISH_ACTIVE;
            $model->created_at = time();
            $model->updated_at = time();

            if($model->save()){
                return $this->redirect(['countries/index', 'query' => $model]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'country'=> $country,
                'id' => $_GET['id'],
            ]);
        }
    }

    /**
     * Updates an existing states model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $country = Countries::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
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
                        'pageSize' => 200,
                    ],
                ]);
                return $this->redirect(['countries/index', 'query' => $model]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'country'=> $country,
            ]);
        }
    }

    /**
     * Deletes an existing states model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Cities::deleteAll('city_id = :id', [':id' => $id]);
        $model = Countries::find()->all();
        return $this->redirect(['countries/index', 'query' => $model]);
    }

    /**
     * Finds the states model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return states the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = States::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCountry($id)
    {
        $model = Countries::find()->where(['id'=> $id])->one();
        $data = [];
        if (!empty($model))
        {
            foreach ($model->options as $option)
            {
                $data[$option['min'] . '-' . $option['max']] = number_format($option['min'], 0, '', '.') . ' - ' . number_format($option['max'], 0, '', '.');
            }
        }
        return $data;
    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($_POST['type'] == 'state')
        {
            if ($_POST['act'] == "close")
                $publish = States::PUBLISH_NONEACTIVE;
            else
                $publish = States::PUBLISH_ACTIVE;

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
                $publish = Cities::PUBLISH_NONEACTIVE;
            else
                $publish = Cities::PUBLISH_ACTIVE;
            $model = Cities::findOne($_POST['id']);
            $model->publish = $publish;
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }
    }
}
