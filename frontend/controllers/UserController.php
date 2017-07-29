<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use common\models\ShTransfer;
use frontend\models\EditUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends FrontendController
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
    public function actionView()
    { 
		if (Yii::$app->user->isGuest){      
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('user/view/'));
        }
        $this->canUser();

        $user = User::findOne(Yii::$app->user->identity->id);
        $cities = Cities::find()->all();
        $states = States::find()->all();
        $countries = Countries::find()->all();

        $direct_members = User::find()->where(['referral_user_id'=>Yii::$app->user->identity->id, 'status' => User::STATUS_ACTIVE])->all();
        $user_active = [];
        $time = time() - (86400 * 30);
        foreach ($direct_members as $key => $value) {
            $shTransfer_active = ShTransfer::find()->where(['user_id' => $value->id])->count();
            if( ($shTransfer_active > 0) && ($value->block == User::BLOCK_NOACTIVE) ){
                $user_active[] = $value->id;
            }
        }
        // var_dump($countries); exit;
        // var_dump($model); exit;
        return $this->render('view', [
            'user'      => $user,
            'model'     => $user,
            'cities'    => $cities,
            'states'    => $states,
            'countries' => $countries,
            'direct_members' => count($direct_members),
            'user_active' => count($user_active),
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
    public function actionUpdate()
    {
      if (Yii::$app->user->isGuest){      
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('user/update/'));
        }
        $this->canUser();
        $model = $this->findModel(Yii::$app->user->identity->id);
        $direct_members = User::find()->where(['referral_user_id'=>Yii::$app->user->identity->id, 'status' => User::STATUS_ACTIVE])->all();
        $user_active = [];
        $time = time() - (86400 * 30);
        foreach ($direct_members as $key => $value) {
            $shTransfer_active = ShTransfer::find()->where(['user_id' => $value->id])->count();
            if( ($shTransfer_active > 0) && ($value->block == User::BLOCK_NOACTIVE) ){
                $user_active[] = $value->id;
            }
        }
        if ($model->load(Yii::$app->request->post())){
            $model->fullname = $model->fullname;
            $model->sex = $model->sex;
            $model->phone = ltrim($model->phone, '0');
            $model->address = $model->address;
            $model->passport_id = $model->passport_id;
            $model->city_id = $model->city_id;
            $model->state_id = $model->state_id;
            $model->postcode = $model->postcode;
            $model->country_id = $model->country_id;
            $my_date = strtotime(str_replace("/", "-", $model->birthday));
            $model->birthday = (string)$my_date;
            if ($model->save()) {
                return $this->redirect(['view']);
            }
        }
        return $this->render('update',[
            'model' => $model,
            'direct_members' => count($direct_members),
            'user_active' => count($user_active),
        ]);
    }

    public function actionUpdatesetting(){
        $user_id = $_POST['user_id'];
        $status =$_POST['status'];

        $model = $this->findModel($user_id);

        $model->fa_setting = $status;
        if($model->save(false)){
            echo "1";exit;
        }else{
            echo "0";exit;
        }
    }

    public function actionCheckpass(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel(Yii::$app->user->identity->id);
        $pass_old = $_POST['current_pass'];
        $hash = Yii::$app->user->identity->password_hash;
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);
        $mailtemplate = new MailTemplate;
        if (Yii::$app->getSecurity()->validatePassword($pass_old, $hash)){
            $length = 6;
            $chars = array_merge(range(0,9));
            shuffle($chars);
            $model->otp= implode(array_slice($chars, 0, $length));
            if ($model->save()) {
                $contentmail = '<p style="margin:0">Your OTP code is '.$model->otp.'</p><p style="margin:0">Please use this code to complete your action.</p>';
                $mailin->
                    addTo($model->email)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                    setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                    setSubject('OTP request for changing Bitway password')->
                    setText('Hello '.$model->fullname.'!')->
                    setHtml($mailtemplate->loadMailtemplate($model->fullname, $contentmail));
                $res = $mailin->send();
                if($res){
                    return true;
                }
            }
        }else{
            return false;
        }

    }

    public function actionInfoupdate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel(Yii::$app->user->identity->id);

        
        $pass_old = ($_POST['current_pass']);
        $pass_otp = ($_POST['pass_otp']);
        $hash = Yii::$app->user->identity->password_hash;
        $hash_new = Yii::$app->getSecurity()->generatePasswordHash($_POST['new_pass_2']);     
             
        if (Yii::$app->getSecurity()->validatePassword($pass_old, $hash) && ($pass_otp == $model->otp)) {
            $model->password_hash = $hash_new;
            $model->otp = '';
            if ($model->save()) {
                Yii::$app->user->logout();
                return true;
                      
            }                
        }
        else{
            return false;
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

        //send mail khi upload hình
        $model->sendmailupload($id);

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

        //send mail khi upload hình
        $model->sendmailupload($id);

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

        //send mail khi upload hình
        $model->sendmailupload($id);

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

    public function actionSetlanguage(){
        $session = Yii::$app->session;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $lang = $_POST['lang'];
        if(!empty($lang)){
            $session->set('language', $lang);
            return 'ok';
        }
    } 
}
