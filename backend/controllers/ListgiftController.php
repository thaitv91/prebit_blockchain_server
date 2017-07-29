<?php

namespace backend\controllers;

use Yii;
use common\models\ListGift;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ListgiftController implements the CRUD actions for ListGift model.
 */
class ListgiftController extends BackendController
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
     * Lists all ListGift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ListGift::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ListGift model.
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
     * Creates a new ListGift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ListGift();
        if ($model->load(Yii::$app->request->post())) {
            $model->thumbnail = $model->thumbnail;
            $model->name = $model->name;
            $model->publish = ListGift::PUBLISH_ACTIVE;
            $model->created_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Can not created gift!');
                return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ListGift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->thumbnail = $model->thumbnail;
            $model->name = $model->name;
            $model->publish = ListGift::PUBLISH_ACTIVE;
            $model->created_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Can not update gift!');
                return $this->render('update', ['model' => $model]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ListGift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $deleteSpinWheel = SpinWheel::deleteAll('id_luckywheel = '.$id);
        $deleteGiftLuckywheel = GiftLuckywheel::deleteAll('id_luckywheel = '.$id);
        $model = $this->findModel($id);
        $payment_receipt_img_full_path = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/uploads/luckywheel/"; 
        $thumbnail = $payment_receipt_img_full_path.$model->thumbnail;
        if (file_exists($thumbnail)) {
            unlink($thumbnail);
        }    
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the ListGift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListGift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ListGift::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionUpdategift()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/uploads/luckywheel/"; 

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg");
            $allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
            $allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "CD".$unique_time;
            $uploadfilename = $_FILES["file"]["name"];

            $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
                    
            if (!in_array($fileext,$allowedfiletypes)){
                echo  1; 
            }   
            else{
                $fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
                $unique_name = $unique_name.".".$fileext;
                $time = date('Y-m-d H:i:s');

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
                    return $unique_name;
                } else {
                    echo  1;
                }
            }
        }   
    }   


    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);

        if ($model->publish == ListGift::PUBLISH_NOACTIVE){
            $publish = ListGift::PUBLISH_ACTIVE;
        }else{
            $publish = ListGift::PUBLISH_NOACTIVE;
        }
        $model->publish = $publish;
        if($model->save()){
            return ['ok'];
        }
    }  
}
