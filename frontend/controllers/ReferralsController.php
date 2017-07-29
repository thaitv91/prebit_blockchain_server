<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\ShTransfer;
use common\models\Conversation;
use common\models\ChatMessages;
use frontend\models\SearchuserForm;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReferralsController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('referrals/index'));
        }
        $this->canUser();
        $model = new User;
        $searchuser = new SearchuserForm;

        if(!empty($_GET['id'])) {
            $id_user = $_GET['id'];
        } else {
            $id_user = Yii::$app->user->identity->id;
        }

        //get network of user login
        $data_member = array();
        $members_network_of_userlog = array();
        $members_network_log = $model->getDownlinetreemember(Yii::$app->user->identity->id, $data_member);
        foreach ($members_network_log as $arr_mem) {
            foreach ($arr_mem as $id_mem) {
                $members_network_of_userlog[] .= $id_mem;
            }
        }

        //check iseet id_user
        $this_user = User::findOne($id_user);
        if(empty($this_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        //check id_user in members network of user login
        if( ($id_user != Yii::$app->user->identity->id) && (!in_array($id_user, $members_network_of_userlog)))
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        } 

        // search username
        if ($searchuser->load(Yii::$app->request->post())) {
            $username = $searchuser->username;
            $username_result = User::find()->where(['referral_user_id' => Yii::$app->user->identity->id, 'status' => User::STATUS_ACTIVE])->andWhere(['LIKE', 'username', $username])->orderBy(['created_at' => SORT_ASC])->all();
            return $this->render('search_result', ['this_user'=>$this_user, 'keyword'=>$username, 'username_result'=>$username_result, 'searchuser'=>$searchuser]);
        }

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

                //gửi mail khi có tin nhắn mới
                $conversation->sendmailsessage($conversation->id, $userid);

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
                        //$content_message = '<img class="fileatch" src="'.Yii::$app->params['site_url'].'uploads/messages/'.$newchatmessages->content.'">';
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


            }
        }
        
    	$user = User::find()->where(['referral_user_id' => $id_user, 'status' => User::STATUS_ACTIVE])->orderBy(['created_at' => SORT_ASC])->all();

        if(!empty($this_user->referral_user_id)){
            $referral_user_id = User::findOne($this_user->referral_user_id);
        } else {
            $referral_user_id = '';
        }
        
    	$user_active = [];
    	$user_noactive = [];
    	$user_current = [];
    	$time = time() - (86400 * 30);
    	foreach ($user as $key => $value) {
    		//$shTransfer_active = ShTransfer::find()->where(['user_id' => $value->id])->andWhere(['>', 'created_at', $time])->count();
            $shTransfer_active = ShTransfer::find()->where(['user_id' => $value->id])->count();
    		$shTransfer_current = ShTransfer::find()->where(['user_id' => $value->id])->count();
    		if( ($shTransfer_active > 0) && ($value->block == User::BLOCK_NOACTIVE) ){
    			$user_active[] = $value->id;
    		}
    		if( empty($shTransfer_active) && ($value->block == User::BLOCK_NOACTIVE) ){
    			$user_noactive[] = $value->id;
    		}
    		if( $value->block == User::BLOCK_ACTIVE ){
    			$user_current[] = $value->id;
    		}
    	}

        //members network
        $data = array();
        $members_network = $this_user->getDownlinetreemember($this_user->id, $data);
        //total sh members network in last month
        $fday_lastmonth = strtotime(date("Y-n-j", strtotime("first day of previous month")));
        $lday_lastmonth = strtotime(date("Y-n-j", strtotime("last day of previous month")));
        $sumsh_network_lastmonth = 0;
        foreach ($members_network as $key => $value) {
            foreach ($value as $id_member) {
                $sum_sh = ShTransfer::find()->where(['user_id' => $id_member])->andWhere(['>=','created_at', $fday_lastmonth])->andWhere(['<=','created_at', $lday_lastmonth])->sum('amount');
                $sumsh_network_lastmonth += $sum_sh;
            }
        }
        //total sh members network in this month
        $fday_thismonth = strtotime(date("Y-n-j", strtotime("first day of this month")));
        $lday_thismonth = strtotime(date("Y-n-j", strtotime("last day of this month")));
        $sumsh_network_thismonth = 0;
        foreach ($members_network as $key => $value) {
            foreach ($value as $id_member) {
                $sum_sh = ShTransfer::find()->where(['user_id' => $id_member])->andWhere(['>=','created_at', $fday_thismonth])->andWhere(['<=','created_at', $lday_thismonth])->sum('amount');
                $sumsh_network_thismonth += $sum_sh;
            }
        }
        //total sh members network 
        $sumsh_network = 0;
        foreach ($members_network as $key => $value) {
            foreach ($value as $id_member) {
                $sum_sh = $model->getTotalSh($id_member);
                $sumsh_network += $sum_sh;
            }
        }

        return $this->render('index', ['this_user'=>$this_user, 'user_active' => $user_active, 'user_noactive' => $user_noactive, 'user_current' => $user_current, 'referral_user_id' => $referral_user_id, 'members_network'=>$members_network, 'memberf1'=>$user, 'sumsh_network_lastmonth'=>$sumsh_network_lastmonth, 'sumsh_network_thismonth'=>$sumsh_network_thismonth,'sumsh_network'=>$sumsh_network, 'searchuser'=>$searchuser]);
    }

    public function actionLoadconversation(){
        $session = Yii::$app->session;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data_user = $_POST['data_user'];
        $data_id = $_POST['data_id'];

        $user_id = User::findOne($data_id);

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
                $arrdata = array($string.'</ul></div>', $conversation->id, $user_id->username);
                return $arrdata;
            } else {
                $arrdata = array('', $conversation->id, $user_id->username);
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
}
