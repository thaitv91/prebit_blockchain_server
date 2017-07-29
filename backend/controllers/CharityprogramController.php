<?php

namespace backend\controllers;

use Yii;
use common\models\CharityProgram;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CharityProgramController implements the CRUD actions for CharityProgram model.
 */
class CharityprogramController extends BackendController
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
     * Lists all CharityProgram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CharityProgram::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CharityProgram model.
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
     * 
     * Creates a new CharityProgram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CharityProgram();
        if ($model->load(Yii::$app->request->post())){
            $model->title  = $model->title;
            $model->content  = $model->content;

            $start_date = $model->startday;
            $start_date = date('Y-m-d', strtotime($start_date));                  
            $model->startday = strtotime($start_date);
            $end_date = $model->endday;
            $end_date = date('Y-m-d', strtotime($end_date));
            $model->endday = strtotime($end_date);
            $model->amount = $model->amount;
            $model->note   = $model->note;

            $imageName = $model->amount;
            $model->file = UploadedFile::getInstance($model,'file');
            $save_folder = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/images/charity/";
            $model->file->saveAs($save_folder.$imageName.'.'.$model->file->extension);
            $model->feature_images = $save_folder.$imageName.'.'.$model->file->extension;

            $model->created_at = time();
            $model->updated_at = time();
            $model->status =  CharityProgram::STATUS_ACITVE;
            $model->publish = CharityProgram::PUBLISH_ACTIVE;

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CharityProgram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->title  = $model->title;            
            $model->content  = $model->content;
            $start_date = $model->startday;
            $start_date = date('Y-m-d', strtotime($start_date));                  
            $model->startday = strtotime($start_date);
            $end_date = $model->endday;
            $end_date = date('Y-m-d', strtotime($end_date));
            $model->endday = strtotime($end_date);
            $model->amount = $model->amount;
            $model->note   = $model->note;

            $imageName = $model->amount;
            $model->file = UploadedFile::getInstance($model,'file');
            $save_folder = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/images/charity/";
            $model->file->saveAs($save_folder.$imageName.'.'.$model->file->extension);
            $model->feature_images = $save_folder.$imageName.'.'.$model->file->extension;

            $model->created_at = time();
            $model->updated_at = time();
            $model->status =  CharityProgram::STATUS_ACITVE;
            $model->publish = CharityProgram::PUBLISH_ACTIVE;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CharityProgram model.
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
     * Finds the CharityProgram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CharityProgram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CharityProgram::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
