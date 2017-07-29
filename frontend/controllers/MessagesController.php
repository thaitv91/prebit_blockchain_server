<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Conversation;
use common\models\ChatMessages;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MessagesController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('referrals/index'));
        }
        $this->canUser();



        if (Yii::$app->request->post()) {
            $userfirst  = Yii::$app->request->post('userone');
            $usersecond = Yii::$app->request->post('usersecond');
            $userid     = Yii::$app->user->identity->id;
            $message    = Yii::$app->request->post('message');
            $lastdiv    = Yii::$app->request->post('lastdiv');
            $fileatch   = Yii::$app->request->post('file_atch');

            if(!empty($message) || !empty($fileatch)){

                $newconversation = new Conversation;

                //find conversation
                $conversation = Conversation::find()->where(['user_first'=>$userfirst, 'user_second'=>$usersecond])->orWhere(['user_first'=>$usersecond, 'user_second'=>$userfirst])->one();
                //get last message on convesation
                $chatmessages = ChatMessages::find(['id_conversation'=>$conversation->id])->orderBy(['created_at'=>SORT_DESC])->limit(1)->one();

                //gán class name cho div message
                if($userid == $conversation->user_first){
                    $class = "chat_message_right";
                } else {
                    $class = "";
                }

                if(!empty($chatmessages)){
                    $userlast = $chatmessages->user_id;

                    // insert message
                    $newchatmessages = new ChatMessages;
                    $newchatmessages->id_conversation = $conversation->id;
                    $newchatmessages->user_id = $userid;
                    if(!empty($fileatch)){
                        $newchatmessages->content = $fileatch;
                        $newchatmessages->type = ChatMessages::TYPE_IMAGE;
                    }
                    if(!empty($message)){
                        $newchatmessages->content = $message;
                        $newchatmessages->type = ChatMessages::TYPE_TEXT;
                    }
                    $newchatmessages->status = ChatMessages::STATUS_NOACTIVE;
                    $newchatmessages->created_at = time();
                    $newchatmessages->save();

                    //get user_id reciever message
                    if($conversation->user_first == $userid){
                        $user_reciever = $conversation->user_second;
                    }else{
                        $user_reciever = $conversation->user_first;
                    }

                    //count conversation user reciever not seen
                    $count_notseen = $newconversation->getCountconversation($user_reciever);

                    //type messages
                    if($newchatmessages->type == ChatMessages::TYPE_TEXT){
                        $content_message = $newchatmessages->content;
                    }
                    if($newchatmessages->type == ChatMessages::TYPE_IMAGE){
                        $content_message = '<a href="'.Yii::$app->params['url_file'].'uploads/messages/'.$newchatmessages->content.'" target="_blank"><img src="'.Yii::$app->params['url_file'].'uploads/messages/'.$newchatmessages->content.'" class="fileatch"></a>';
                        //$content_message = '<img class="fileatch" src="'.Yii::$app->params['site_url'].'uploads/messages/'.$newchatmessages->content.'>';
                    }

                    if($userlast == $userid){
                        

                        $content = '<div class="chat_message_wrapper '.$class.'" data="'.$class.'">
                                        <div class="chat_user_avatar"></div>
                                        <ul class="chat_message"><li><p>'.$content_message.'</p></li></ul>
                                    </div>';
                        return Yii::$app->redis->executeCommand('PUBLISH', [
                            'channel' => 'notification',
                            'message' => Json::encode(['content' => $content, 'conversation' => $conversation->id, 'lastdiv' => $class, 'user_reciever' => $user_reciever, 'count_notseen' => $count_notseen])
                        ]);
                    } else {

                        $avatar = $newchatmessages->getUser($userid)->avatar;
                        if(!empty($avatar)){
                            $src = 'uploads/users/'.$avatar;
                        }else{
                            $src = '/uploads/users/default-avatar.jpg';
                        }

                        $content = '<div class="chat_message_wrapper '.$class.'" data="'.$class.'">
                                        <div class="chat_user_avatar">
                                            <img alt="'.$newchatmessages->getUser($userid)->username.'" src="'.Yii::$app->params['url_file'].''.$src.'" class="md-user-image">
                                        </div>
                                        <ul class="chat_message"><li><p>'.$content_message.'</p></li></ul>
                                    </div>';
                        return Yii::$app->redis->executeCommand('PUBLISH', [
                            'channel' => 'notification',
                            'message' => Json::encode(['content' => $content, 'conversation' => $conversation->id, 'lastdiv' => $class, 'user_reciever' => $user_reciever, 'count_notseen' => $count_notseen])
                        ]);
                    }

                } else {

                    // insert message
                    $newchatmessages = new ChatMessages;
                    $newchatmessages->id_conversation = $conversation->id;
                    $newchatmessages->user_id = $userid;
                    if(!empty($fileatch)){
                        $newchatmessages->content = $fileatch;
                        $newchatmessages->type = ChatMessages::TYPE_IMAGE;
                    }
                    if(!empty($message)){
                        $newchatmessages->content = $message;
                        $newchatmessages->type = ChatMessages::TYPE_TEXT;
                    }
                    $newchatmessages->status = ChatMessages::STATUS_NOACTIVE;
                    $newchatmessages->created_at = time();
                    $newchatmessages->save();

                    //get user_id reciever message
                    if($conversation->user_first == $userid){
                        $user_reciever = $conversation->user_second;
                    }else{
                        $user_reciever = $conversation->user_first;
                    }

                    //count conversation user reciever not seen
                    $count_notseen = $newconversation->getCountconversation($user_reciever);

                    //type messages
                    if($newchatmessages->type == ChatMessages::TYPE_TEXT){
                        $content_message = $newchatmessages->content;
                    }
                    if($newchatmessages->type == ChatMessages::TYPE_IMAGE){
                        $content_message = '<a href="'.Yii::$app->params['url_file'].'uploads/messages/'.$newchatmessages->content.'" target="_blank"><img src="'.Yii::$app->params['url_file'].'uploads/messages/'.$newchatmessages->content.'" class="fileatch"></a>';
                        //$content_message = '<img class="fileatch" src="'.Yii::$app->params['site_url'].'uploads/messages/'.$newchatmessages->content.'>';
                    }

                    $avatar = $newchatmessages->getUser($userid)->avatar;
                    if(!empty($avatar)){
                        $src = 'uploads/users/'.$avatar;
                    }else{
                        $src = '/uploads/users/default-avatar.jpg';
                    }

                    $content = '<div class="chat_message_wrapper '.$class.'" data="'.$class.'">
                                    <div class="chat_user_avatar">
                                        <img alt="'.$newchatmessages->getUser($userid)->username.'" src="'.Yii::$app->params['url_file'].''.$src.'" class="md-user-image">
                                    </div>
                                    <ul class="chat_message"><li><p>'.$content_message.'</p></li></ul>
                                </div>';
                        return Yii::$app->redis->executeCommand('PUBLISH', [
                            'channel' => 'notification',
                            'message' => Json::encode(['content' => $content, 'conversation' => $conversation->id, 'lastdiv' => $class, 'user_reciever' => $user_reciever, 'count_notseen' => $count_notseen])
                        ]);
                }

                //gửi mail khi có tin nhắn mới
                $conversation->sendmailsessage($conversation->id);
            }
        }

        $user = User::findOne(Yii::$app->user->identity->id);
        $conversations = $conversation = Conversation::find()->where(['user_first'=>$user->id])->orWhere(['user_second'=>$user->id])->orderBy(['created_at'=>SORT_DESC])->all();
        $list_conversation = array();
        if(!empty($conversations)){
            foreach ($conversations as $key => $convers) {
                $messages = ChatMessages::find()->where(['id_conversation' => $convers->id])->andWhere(['<>', 'user_id', Yii::$app->user->identity->id])->orderBy(['created_at'=>SORT_DESC])->one();
                if(!empty($messages)){
                    $user_convert = User::findOne($messages->user_id);
                    $list_conversation[$key]['username'] = $user_convert->username;
                    $list_conversation[$key]['avatar'] = $user_convert->avatar;
                    $list_conversation[$key]['lastmessage'] = $messages->content;
                    $list_conversation[$key]['data-user'] = $user->id;
                    $list_conversation[$key]['data-id'] = $messages->user_id;
                }
            }
        }


        
        return $this->render('index', ['list_conversation' => $list_conversation]);
    }

    public function actionLoadconversation(){
        $session = Yii::$app->session;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data_user = $_POST['data_user'];
        $data_id = $_POST['data_id'];

        $conversation = Conversation::find()->where(['user_first'=>$data_user, 'user_second'=>$data_id])->orWhere(['user_first'=>$data_id, 'user_second'=>$data_user])->one();


        if(!empty($conversation)){

            //update status messages
            $notseen_messages = ChatMessages::find()->where(['id_conversation'=>$conversation->id, 'status'=>ChatMessages::STATUS_NOACTIVE])->andWhere(['<>','user_id', Yii::$app->user->identity->id])->orderBy(['created_at'=>SORT_ASC])->all();
            if(!empty($notseen_messages)){
                foreach ($notseen_messages as $key => $messages) {
                    $message = ChatMessages::findOne($messages->id);
                    $message->status = ChatMessages::STATUS_ACTIVE;
                    $message->save();
                }
            }

            $chatmessages = ChatMessages::find()->where(['id_conversation'=>$conversation->id])->orderBy(['created_at'=>SORT_ASC])->all();
            $firstmessage = ChatMessages::find()->where(['id_conversation'=>$conversation->id])->orderBy(['created_at'=>SORT_ASC])->one();
            if(!empty($chatmessages)){
                if( $firstmessage->user_id == $conversation->user_first ){
                    $class = "chat_message_right";
                } else {
                    $class = "";
                }

                $avatar = $firstmessage->getUser($firstmessage->user_id)->avatar;
                if(!empty($avatar)){
                    $src = 'uploads/users/'.$avatar;
                }else{
                    $src = '/uploads/users/default-avatar.jpg';
                }

                $string = '<div class="chat_message_wrapper '.$class.'" data="'.$class.'">
                                    <div class="chat_user_avatar">
                                        <img alt = "'.$firstmessage->getUser($firstmessage->user_id)->username.'" src="'.Yii::$app->params['url_file'].''.$src.'" class="md-user-image">
                                    </div>
                                    <ul class="chat_message">';

                $tam = $conversation->user_first;                
                foreach ($chatmessages as $key => $message) {
                    if($message->user_id == $tam){
                        $tam = $message->user_id;
                        $divclass = "";
                        if( $message->user_id == $conversation->user_first ){
                            $class = "chat_message_right";
                        } else {
                            $class = "";
                        }
                    } else {
                        $tam = $message->user_id;
                        if( $message->user_id == $conversation->user_first ){
                            $class = "chat_message_right";
                        } else {
                            $class = "";
                        }

                        $avatar = $message->getUser($message->user_id)->avatar;
                        if(!empty($avatar)){
                            $src = 'uploads/users/'.$avatar;
                        }else{
                            $src = '/uploads/users/default-avatar.jpg';
                        }
                        
                        $divclass = '</ul>
                                    </div>
                                    <div class="chat_message_wrapper '.$class.'" data="'.$class.'">
                                        <div class="chat_user_avatar">
                                            <img alt="'.$message->getUser($message->user_id)->username.'" src="'.Yii::$app->params['url_file'].''.$src.'" class="md-user-image">
                                        </div>
                                        <ul class="chat_message">';
                    }

                    Yii::$app->getSession()->setFlash('classdivchat', $class);

                    //type messages
                    if($message->type == ChatMessages::TYPE_TEXT){
                        $content_message = $message->content;
                    }
                    if($message->type == ChatMessages::TYPE_IMAGE){
                        $content_message = '<a href="'.Yii::$app->params['url_file'].'uploads/messages/'.$message->content.'" target="_blank"><img src="'.Yii::$app->params['url_file'].'uploads/messages/'.$message->content.'" class="fileatch"></a>';
                    }

                    $string .= $divclass.'<li><p>'.$content_message.'</p></li>';
                }
                $arrdata = array($string.'</ul></div>', $conversation->id);
                return $arrdata;
            } else {
                $arrdata = array('', $conversation->id);
                return $arrdata;
            }
        } else {
            $conversation = new Conversation;
            $conversation->user_first = $data_user;
            $conversation->user_second = $data_id;
            $conversation->status = Conversation::STATUS_ACTIVE;
            $conversation->publish = Conversation::PUBLISH_ACTIVE;
            $conversation->created_at = time();
            $conversation->save();
        }
    }


    public function actionMessagesseen(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data_user = $_POST['data_user'];
        $data_id = $_POST['data_id'];

        $conversation = Conversation::find()->where(['user_first'=>$data_user, 'user_second'=>$data_id])->orWhere(['user_first'=>$data_id, 'user_second'=>$data_user])->one();

        if(!empty($conversation)){
            $chatmessages = ChatMessages::find()->where(['id_conversation'=>$conversation->id, 'status'=>ChatMessages::STATUS_NOACTIVE])->andWhere(['<>','user_id', Yii::$app->user->identity->id])->orderBy(['created_at'=>SORT_ASC])->all();
            if(!empty($chatmessages)){
                foreach ($chatmessages as $key => $messages) {
                    $message = ChatMessages::findOne($messages->id);
                    $message->status = ChatMessages::STATUS_ACTIVE;
                    $message->save();
                }
            }
        }
    }

    public function actionLoadlistmessage(){
        //get conversation not seen
        $conversations = Conversation::find()->where(['user_first'=>Yii::$app->user->identity->id])->orWhere(['user_second'=>Yii::$app->user->identity->id])->all();
        $count_conver = 0;
        $arr_conver = array();
        $string = '';
        if(!empty($conversations)){
            foreach ($conversations as $key => $convers) {
                $messages = ChatMessages::find()->where(['id_conversation' => $convers->id, 'status' => ChatMessages::STATUS_NOACTIVE])->andWhere(['<>', 'user_id', Yii::$app->user->identity->id])->one();
                if(!empty($messages)){
                    $user = User::findOne($messages->user_id);
                    $count_conver += 1;
                    $arr_conver[$key]['data-user'] = Yii::$app->user->identity->id;
                    $arr_conver[$key]['data-id'] = $user->id;
                    $arr_conver[$key]['conver'] = $convers->id;
                    $arr_conver[$key]['username'] = $user->username;
                }
            }
        }

        if(count($arr_conver) > 0){
            foreach ($arr_conver as $key => $conv) {
                $string .= '<li><a href="javascript:;" class="btnchat btncountchat" data-user="'.$conv['data-user'].'" data-id="'.$conv['data-id'].'"><p><strong>'.$conv['username'].'</strong> Send you a message </p></a></li>';
            }
        }
        return $string;
    }

    public function actionCountconversation(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $userid = $_POST['userid'];
        $newconversation = new Conversation;
        $count_notseen = $newconversation->getCountconversation($userid);
        if($count_notseen > 0){
            return $count_notseen;
        }else{
            return '';
        }
    }

    public function actionUploadfile(){
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $payment_receipt_img_full_path = $_SERVER['DOCUMENT_ROOT']."/uploads/messages/"; 

        if ( !$_FILES["file"]["name"] ) {
                echo "Can't upload!";
            }
        else {
            $allowedfiletypes = array("jpg" , "png" , "jpeg");
            $allowedfile_img = array("jpg" , "png" , "jpeg");
            $allowedfile_file = array();
            $uploadfolder = $payment_receipt_img_full_path;

            $thumbnailheight = 100; //in pixels
            $thumbnailfolder = $uploadfolder."thumbs/" ;

            $unique_time = time();
            $unique_name =  "MS".$unique_time;
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
                    return $unique_name;
                } else {
                    echo  1;
                }
            }
        }    
    }
}
