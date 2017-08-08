<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Countries;
use common\models\Converted;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use common\models\ShTransfer;
use backend\models\UserFilter;
use backend\models\ShTransferFilter;
use backend\components\PTotal;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\models\BlockList;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BackendController
{

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

    public function actionIndex()
    {
		 
		/* $ip   = $_SERVER['REMOTE_ADDR'];
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
		$country=$details->geoplugin_countryCode;
		if($country==="JP"){
		throw new NotFoundHttpException('The requested page does not exist.');
		} */
        $userfilter = new UserFilter;
        $query = User::find();
        if ($userfilter->load(Yii::$app->request->get())) {
            $query->where(['>', 'id', '0']);
            if(!empty($userfilter->username)){
                $query->andWhere(['LIKE', 'username', $userfilter->username]);
            }
            if(!empty($userfilter->fullname)){
                $query->andWhere(['LIKE', 'fullname', $userfilter->fullname]);
            }
            if(!empty($userfilter->phone)){
                $query->andWhere(['LIKE', 'phone', $userfilter->phone]);
            }
            if(!empty($userfilter->email)){
                $query->andWhere(['LIKE', 'email', $userfilter->email]);
            }
            if(!empty($userfilter->status)){
                $query->andWhere(['status'=>$userfilter->status]);
            }
            if(!empty($userfilter->publish)){
                $query->andWhere(['publish'=>$userfilter->publish]);
            }
            if(!empty($userfilter->level)){
                $query->andWhere(['level'=>$userfilter->level]);
            }
            if(!empty($userfilter->shstatus)){
                $query->andWhere(['shstatus'=>$userfilter->shstatus]);
            }
            if(!empty($userfilter->downline)){
                if($userfilter->downline == User::ORDERBY_DOWNLINE_DESC){
                    $query->orderBy(['downline'=>SORT_DESC]);
                }
                if($userfilter->downline == User::ORDERBY_DOWNLINE_ASC){
                    $query->orderBy(['downline'=>SORT_ASC]);
                }
            }
            if(!empty($userfilter->country)){
                $query->andWhere(['country_id'=>$userfilter->country]);
            }
            if(!empty($userfilter->dayfrom)){
                $date=date_create($userfilter->dayfrom);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($userfilter->dayto)){
                $date=date_create($userfilter->dayto);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }
            

        }else{
            $query->where(['>', 'id', '0']);
        }

        $query->andWhere(['<>', 'country_id', '23']);

        $model = $query->all();
        $total_wallet = 0;
        $total_bonus = 0;
        foreach ($model as $md) {
            $total_wallet = $total_wallet + $md['wallet'];
            $total_bonus = $total_bonus + $md['manager_bonus'] + $md['referral_bonus'];
        }

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'userfilter' => $userfilter,
            'total_wallet' => $total_wallet,
            'total_bonus' => $total_bonus
        ]);
    }

    public function actionView($id)
    {
        define("IN_WALLET", true);
        $user = User::findOne($id);

        $userfilter = new UserFilter;
        $query = User::find()->where(['referral_user_id'=>$id]);

        $sh_datefrom = '';
        $sh_dateto = '';
        
        if ($userfilter->load(Yii::$app->request->get())) {
            $query->where(['referral_user_id'=>$id]);
            if(!empty($userfilter->status)){
                $query->andWhere(['status'=>$userfilter->status]);
            }
            if(!empty($userfilter->publish)){
                $query->andWhere(['publish'=>$userfilter->publish]);
            }
            if(!empty($userfilter->shstatus)){
                $query->andWhere(['shstatus'=>$userfilter->shstatus]);
            }
            if(!empty($userfilter->level)){
                $query->andWhere(['level'=>$userfilter->level]);
            }
            if(!empty($userfilter->dayfrom)){
                $date=date_create($userfilter->dayfrom);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">", "created_at", $datefrom]);
            }
            if(!empty($userfilter->dayto)){
                $date=date_create($userfilter->dayto);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<", "created_at", $dateto]);
            }
            if(!empty($userfilter->dayfromsh) && !empty($userfilter->daytosh)){
                $fromdate=date_create($userfilter->dayfromsh);
                $datefrom = strtotime(date_format($fromdate,"m/d/Y"));

                $sh_datefrom = $datefrom;

                $todate=date_create($userfilter->daytosh);
                $dateto = strtotime(date_format($todate,"m/d/Y 23:59"));

                $sh_dateto = $dateto;

                $userf1 = User::find()->where(['referral_user_id'=>$id])->all();

                $listf1 = array();
                foreach ($userf1 as  $usernamefi) {
                    $listf1[] = $usernamefi->id;
                }
                $listfi_string = implode(",",$listf1);
                $sqlquery = 'SELECT user_id FROM `sh_transfer` WHERE `user_id` IN ( '.$listfi_string.' ) AND `created_at` > '.$datefrom.' AND `created_at` <= '.$dateto.' GROUP BY `user_id` ';
                $shtransfer = ShTransfer::findBySql($sqlquery)->all();   

                $listfi_sh = array();
                foreach ($shtransfer as $key => $usersh) {
                    $listfi_sh[] = $usersh->user_id;
                }

                $query->andWhere(["IN", "id", $listfi_sh]);
            }
        } else {
            $query->where(['referral_user_id'=>$id]);
        }
        $model_query = $query->orderBy(['created_at'=>SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model_query,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        $grid_columns=[         
            [
                'attribute' => 'level',
                'footer'=>PTotal::pageTotal($dataProvider->models,'level'),
            ]
        ];


        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $balance_btc = $client->getBalance($user->username);
        $address_btc = $client->getAddress($user->username);
        $countries = countries::find()->all();
        return $this->render('view', [
            'model' => $this->findModel($id), 
            'countries' => $countries,
            'balance_btc' => $balance_btc,
            'address_btc' => $address_btc,
            'dataProvider' => $dataProvider,
            'client' => $client,
            'userfilter' => $userfilter,
            'grid_columns' => $grid_columns,
            'sh_dateto' => $sh_dateto,
            'sh_datefrom' => $sh_datefrom,
        ]);
    }

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

    public function actionDeposit($id) {
        $model = ShTransfer::find()->where(['user_id' => $id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $request = Yii::$app->request;
            $amount = $request->post('ShTransfer');
            $model->amount = $amount ["amount"];
            $model->save();
            return $this->redirect(['deposit', 'id' => $model->user_id]);
        } else {
            return $this->render('deposit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if ($model->status == User::STATUS_ACTIVE){
            $status = User::STATUS_NOACTIVE;
        }else{
            $status = User::STATUS_ACTIVE;
        }
            
        $model->status = $status;
        $model->updated_at = time();
        if($model->save()){
            var_dump($model->status);
            return ['ok'];
        }
    }

    public function actionBlock()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $standbyforblock = Converted::find()->where(['object'=>'standbyforblock'])->one();
        $blocklist = new BlockList;
        $model = $this->findModel($_POST['id']);
        if ($model->block == User::BLOCK_ACTIVE){
            $block = User::BLOCK_NOACTIVE;
            $unblock = 0;
        }else{
            $block = User::BLOCK_ACTIVE;
            $unblock = 1;
        }

        $model->block = $block;
        $model->timeblock = time();
        if($model->save()){
            if($unblock == 0){
                $blocklist = BlockList::find()->where(['user_id'=>$model->id, 'status'=>BlockList::BLOCK_ACTIVE])->all();
                foreach ($blocklist as $key => $block) {
                    $blockchange = BlockList::findOne($block->id);
                    $blockchange->status = BlockList::BLOCK_NOACTIVE;
                    $blockchange->updated_at = time();
                    $blockchange->save();
                }
            }
            if($unblock == 1){
                $blocklist->user_id = $model->id;
                $blocklist->status = BlockList::BLOCK_ACTIVE;
                $blocklist->updated_at = time();
                $blocklist->created_at =time();
                $blocklist->save();

                //send mail register
                $mailin->
                    addTo($model->email, $model->username)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'Bitway')->
                    setReplyTo(Yii::$app->params['supportEmail'],'Bitway')->
                    setSubject('Your account has blocked')->
                    setText('Hello '.$model->username.'!')->
                    setHtml('<p>Your Bitway account has been blocked, follow the instructions in your account to unlock it. Please reply to this email if you have any questions.<p>');
                $res = $mailin->send();
            }
            return ['ok'];
        }
    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);
        $mailtemplate = new MailTemplate;

        if ($model->publish == User::PUBLISH_NOACTIVE){
            $publish = User::BLOCK_ACTIVE;
        }else{
            $publish = User::BLOCK_NOACTIVE;
        }
        $model->publish = $publish;
        $model->updated_at = time();
        if($model->save()){
            $contentmail = '<p style="margin:0">Your account has been verified.</p>';
            $mailin->
                addTo($model->email)-> 
                setFrom(Yii::$app->params['supportEmail'], 'Bitway')->
                setReplyTo(Yii::$app->params['supportEmail'],'Bitway')->
                setSubject('Your account has been verified')->
                setText('Hello '.$model->fullname.'!')->
                setHtml($mailtemplate->loadMailtemplate($model->fullname, $contentmail));
            $res = $mailin->send();
            if($res){
                return ['ok'];
            }
        }
    }

    public function actionInfoupdate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if($_POST['type'] == 'birthday'){
            $date = $_POST['value'];
            $model->$_POST['type'] = strtotime($date);
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }
        
        if($_POST['type'] == 'phone'){
            $model->$_POST['type'] = ltrim($_POST['value'], '0');
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }

        $model->$_POST['type'] = $_POST['value'];
        $model->updated_at = time();
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdateemail(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        $email = User::find()->where(['email'=>$_POST['value']])->one();
        if(!empty($email)){
            return ['no'];
        }else{
            $model->email = $_POST['value'];
            $model->updated_at = time();
            if($model->save()){
                return ['ok'];
            }
        }
        
    }

    

    public function actionUpdateavatar($id)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/uploads/users/"; 
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

    public function actionUpdatetotalwithdraw() {
        $users = User::find()->all();
        $count = 0;
        foreach ($users as $user) {
            $active_sh = ShTransfer::find()->where(['user_id'=>$user->id, 'publish'=>ShTransfer::PUBLISH_ACTIVE])->andWhere(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
            $withdraw = 0;
            foreach ($active_sh as $key => $value) {
                $withdraw += $value->amount;
            }
            //var_dump($user->total_withdraw); die();
            $user->total_withdraw = $withdraw * 2;
            $user->save();
            $count++;
            echo $count . ": " . $user->id . ' - ' . $withdraw . ' - ' . $user->total_withdraw .'<br />';
        }
        echo $count;
    }

        // Renew Wallet Address
    public function actionRewallet() {
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $users = User::find()->all();

        foreach ($users as $user) {
            $address_btc = $client->getAddressList($user->username);
             echo "user: " . $user->username . " -> address: " . $address_btc[0] . "<br />";
            //var_dump($address_btc); die();
            if (! $address_btc) {
                // create bitcoin address
                echo "creating address for " . $user->username . "<br />";
                $client->getNewAddress($user->username);
                $address_btc_new = $client->getAddressList($user->username);
                echo "user: " . $user->username . " -> address: " . $address_btc_new[0] . "<br />";
            }
            
        }

    }
}
