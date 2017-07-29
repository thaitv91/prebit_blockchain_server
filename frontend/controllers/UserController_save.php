<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use frontend\models\EditUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
		if (Yii::$app->user->isGuest){            
            return $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect('user/view/'.$id));
        }
        $model = User::find()->all();
        $cities = Cities::find()->all();
        $states = States::find()->all();
        $countries = Countries::find()->all();
        // var_dump($countries); exit;
        // var_dump($model); exit;
        return $this->render('view', [
            'model'     => $this->findModel($id),
            'cities'    => $cities,
            'states'    => $states,
            'countries' => $countries,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $update = EditUser::findOne($id);
        if ($update->load(Yii::$app->request->post())){

            $model->fullname = $update->fullname;
            $model->sex = $update->sex;
            $model->phone = $update->phone;
            $model->address = $update->address;
            $model->passport_id = $update->passport_id;
            $model->city_id = $update->city_id;
            $model->state_id = $update->state_id;
            $model->postcode = $update->postcode;
            $model->country_id = $update->country_id;
            $my_date = $update->birthday;
            $my_date = strtotime(str_replace("/", "-", $my_date));
            $model->birthday = (string)$my_date;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('update',[
            'update' => $update,
        ]);
    }
    public function actionInfoupdate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel(Yii::$app->user->identity->id);

        

        $pass_old = ($_POST['current_pass']);
        $pass_otp = ($_POST['pass_otp']);
        $hash = Yii::$app->user->identity->password_hash;
        $hash_new = Yii::$app->getSecurity()->generatePasswordHash($_POST['new_pass_2']);
        $model->otp = 123456789;
        
        if (Yii::$app->getSecurity()->validatePassword($pass_old, $hash) && $pass_otp == $model->otp) {
            $model->password_hash = $hash_new;
            if($model->save()){
                return 'Pass Changed';

            }

        }else {
          return 'Old Password False';
        }
        
    }
    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetstate()
    {
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $id_country = $_POST['id'];
         $model = States::find()->where(['country_id' => $id_country])->all();

         $str = '<select id=user-state_id class=form-control name=User[state_id]>';
             foreach ($model as $key => $value) {
                 $str .= "<option value=".$value->id.">".$value->name."</option>";
             }
         $str .= '</select><div class=help-block help-block-error></div>';

         return (string)$str;

    }

    public function actionGetcity()
    {
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $id_state = $_POST['id'];
         $model = Cities::find()->where(['state_id' => $id_state])->all();

         $str = '<select id=user-city_id class=form-control name=User[city_id]>';
             foreach ($model as $key => $value) {
                 $str .= "<option value=".$value->id.">".$value->name."</option>";
             }
         $str .= '</select><div class=help-block help-block-error></div>';
         
         return (string)$str;

    }

    public function actionUpdateavatar($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = $_SERVER['DOCUMENT_ROOT']."/uploads/users/"; 
        $model = $this->findModel($id);

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" , "doc" , "docx" , "pdf" , "xls" , "xlsx");
            $allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
            $allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "CD".$unique_time.$id;
            $uploadfilename = $_FILES["file"]["name"];

            $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
                    
            if (!in_array($fileext,$allowedfiletypes)){
                echo  1; 
            }   
            else{
                $fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
                $unique_name = $unique_name.".".$fileext;
                $time = date('Y-m-d H:i:s');

                // if (in_array($fileext,$allowedfile_img)) {
                //     $patch_file = "<a data-img='".$fulluploadfilename."' class='modal-img' href='javascript:void(0)'><img width='100' src='".$fulluploadfilename."'/></a>";
                // }else{
                //     $patch_file = "<i class='fa fa-file-text-o fa-2x' aria-hidden='true'></i>".$unique_name;
                // }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
                    //$img = "<a target='_blank' href='".$fulluploadfilename."' download='".$unique_name."'>".$patch_file."</a>";
                    //$date = date("Y-m-d");
                    $model->avatar = $unique_name;
                    $model->updated_at = time();
                    if($model->save()){
                        return $model->avatar;
                    }
                } else {
                    echo  1;
                }
            }
        }    
    }

    public function actionUpdatepassport($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = $_SERVER['DOCUMENT_ROOT']."/uploads/passport/"; 
        $model = $this->findModel($id);

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" , "doc" , "docx" , "pdf" , "xls" , "xlsx");
            $allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
            $allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "CD".$unique_time.$id;
            $uploadfilename = $_FILES["file"]["name"];

            $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
                    
            if (!in_array($fileext,$allowedfiletypes)){
                echo  1; 
            }   
            else{
                $fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
                $unique_name = $unique_name.".".$fileext;
                $time = date('Y-m-d H:i:s');

                // if (in_array($fileext,$allowedfile_img)) {
                //     $patch_file = "<a data-img='".$fulluploadfilename."' class='modal-img' href='javascript:void(0)'><img width='100' src='".$fulluploadfilename."'/></a>";
                // }else{
                //     $patch_file = "<i class='fa fa-file-text-o fa-2x' aria-hidden='true'></i>".$unique_name;
                // }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
                    //$img = "<a target='_blank' href='".$fulluploadfilename."' download='".$unique_name."'>".$patch_file."</a>";
                    //$date = date("Y-m-d");
                    $model->passport = $unique_name;
                    $model->updated_at = time();
                    if($model->save()){
                        return $model->passport;
                    }
                } else {
                    echo  1;
                }
            }
        }    
    }

    public function actionUpdateidentification($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = $_SERVER['DOCUMENT_ROOT']."/uploads/identification/"; 
        $model = $this->findModel($id);

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" , "doc" , "docx" , "pdf" , "xls" , "xlsx");
            $allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
            $allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "CD".$unique_time.$id;
            $uploadfilename = $_FILES["file"]["name"];

            $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
                    
            if (!in_array($fileext,$allowedfiletypes)){
                echo  1; 
            }   
            else{
                $fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
                $unique_name = $unique_name.".".$fileext;
                $time = date('Y-m-d H:i:s');

                // if (in_array($fileext,$allowedfile_img)) {
                //     $patch_file = "<a data-img='".$fulluploadfilename."' class='modal-img' href='javascript:void(0)'><img width='100' src='".$fulluploadfilename."'/></a>";
                // }else{
                //     $patch_file = "<i class='fa fa-file-text-o fa-2x' aria-hidden='true'></i>".$unique_name;
                // }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
                    //$img = "<a target='_blank' href='".$fulluploadfilename."' download='".$unique_name."'>".$patch_file."</a>";
                    //$date = date("Y-m-d");
                    $model->identification = $unique_name;
                    $model->updated_at = time();
                    if($model->save()){
                        return $model->identification;
                    }
                } else {
                    echo  1;
                }
            }
        }    
    }

    public function actionUpdateselfie($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = $_SERVER['DOCUMENT_ROOT']."/uploads/selfie/"; 
        $model = $this->findModel($id);

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" , "doc" , "docx" , "pdf" , "xls" , "xlsx");
            $allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
            $allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "CD".$unique_time.$id;
            $uploadfilename = $_FILES["file"]["name"];

            $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
                    
            if (!in_array($fileext,$allowedfiletypes)){
                echo  1; 
            }   
            else{
                $fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
                $unique_name = $unique_name.".".$fileext;
                $time = date('Y-m-d H:i:s');

                // if (in_array($fileext,$allowedfile_img)) {
                //     $patch_file = "<a data-img='".$fulluploadfilename."' class='modal-img' href='javascript:void(0)'><img width='100' src='".$fulluploadfilename."'/></a>";
                // }else{
                //     $patch_file = "<i class='fa fa-file-text-o fa-2x' aria-hidden='true'></i>".$unique_name;
                // }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
                    //$img = "<a target='_blank' href='".$fulluploadfilename."' download='".$unique_name."'>".$patch_file."</a>";
                    //$date = date("Y-m-d");
                    $model->selfie = $unique_name;
                    $model->updated_at = time();
                    if($model->save()){
                        return $model->selfie;
                    }
                } else {
                    echo  1;
                }
            }
        }    
    }
}
