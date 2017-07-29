<?php

namespace common\models;

use Yii;
use common\models\Conversation;
use common\extensions\Mailin;
use common\extensions\MailTemplate;

/**
 * This is the model class for table "conversation".
 *
 * @property integer $id
 * @property integer $user_first
 * @property integer $user_second
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 */
class Conversation extends \yii\db\ActiveRecord
{
    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    public static function tableName()
    {
        return 'conversation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_first', 'user_second', 'status', 'publish', 'created_at'], 'required'],
            [['user_first', 'user_second', 'status', 'publish'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_first' => 'User First',
            'user_second' => 'User Second',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }

    public static function getCountconversation($id){
        //get conversation not seen
        $conversations = Conversation::find()->where(['user_first'=>$id])->orWhere(['user_second'=>$id])->all();
        $count_conver = 0;
        if(!empty($conversations)){
            foreach ($conversations as $key => $convers) {
                $messages = ChatMessages::find()->where(['id_conversation' => $convers->id, 'status' => ChatMessages::STATUS_NOACTIVE])->andWhere(['<>', 'user_id', $id])->one();
                if(!empty($messages)){
                    $user = User::findOne($messages->user_id);
                    $count_conver += 1;
                }
            }
        }
        return $count_conver;
    }

    public static function sendmailsessage($conversation, $userid){
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);
        $mailtemplate = new MailTemplate;
        $conversation = Conversation::findOne($conversation);

        //get last message on convesation
        $lastmessages = ChatMessages::find(['id_conversation'=>$conversation->id])->orderBy(['created_at'=>SORT_DESC])->limit(1)->one();

        //get user_id reciever message
        if($conversation->user_first == $userid){
            $user_reciever = $conversation->user_second;
            $user_send = $userid;
        }else{
            $user_reciever = $conversation->user_first;
            $user_send = $userid;
        }

        if(!empty($lastmessages)){
            $user_send = User::findOne($user_send);
            $user_reciver = User::findOne($user_reciever);

            $delaytime = time() - $lastmessages->created_at;
            //5 hour
            if($delaytime >= 10){
                //send mail
                $contentmail = '<p style="margin:0">Your have received a message from <b>'.$user_send->username.'</b>.</p>';
                $mailin->
                    addTo($user_reciver->email)-> 
                    setFrom(Yii::$app->params['verifyEmail'], 'PreBit')->
                    setReplyTo(Yii::$app->params['verifyEmail'],'PreBit')->
                    setSubject('Your have received a message')->
                    setText('Your have received a message')->
                    setHtml($mailtemplate->loadMailtemplate($user_send->fullname, $contentmail));
                $res = $mailin->send();
            }
        }else{
            //send mail
            $user_send = User::findOne($user_send);
            $user_reciver = User::findOne($user_reciever);
            $contentmail = '<p style="margin:0">Your have received a message from <b>'.$user_send->username.'</b>.</p>';
            $mailin->
                addTo($user_reciver->email)-> 
                setFrom(Yii::$app->params['verifyEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['verifyEmail'],'PreBit')->
                setSubject('Your have received a message')->
                setText('Your have received a message')->
                setHtml($mailtemplate->loadMailtemplate($user_send->fullname, $contentmail));
            $res = $mailin->send();
        }
    }
}
