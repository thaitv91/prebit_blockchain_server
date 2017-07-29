<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\NewsmanagementSearch;
use common\models\Newsmanagement;


/**
 * Site controller
 */
class NewsmanagementController extends BackendController
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
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$post = PostsSearch::findAll();
        //var_dump($post); exit;
        $searchModel = new NewsmanagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Newsmanagement();

        if ($model->load(Yii::$app->request->post())){
        	$model->title = $model->title;
        	$model->description = $model->description;
        	$model->content = $model->content;
        	$model->publish = Newsmanagement::PUBLISH_ACTIVE;
            $model->created_at = time();
            $model->updated_at = time();
            
            if($model->save()){
                return $this->redirect(['view', 'id' => (string)$model->id]);
            }
        }else{
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            $model->publish = $model->publish;

            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['view', 'id' => (string)$model->id]);
            }
        }else{
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($_POST['act'] == "close")
            $publish = Newsmanagement::PUBLISH_NOACTIVE;
        else
            $publish = Newsmanagement::PUBLISH_ACTIVE;

        $model = $this->findModel($_POST['id']);
        $model->publish = $publish;
        $model->updated_at = time();
        if($model->save()){
            return ['ok'];
        }
    }
    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Newsmanagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

?>