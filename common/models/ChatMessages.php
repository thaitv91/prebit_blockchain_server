<?php

namespace common\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "chat_messages".
 *
 * @property integer $id
 * @property integer $ic_conversation
 * @property integer $user_id
 * @property string $content
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 */
class ChatMessages extends \yii\db\ActiveRecord
{
    const STATUS_NOACTIVE = 1; //not seen
    const STATUS_ACTIVE = 2; // seen

    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;


    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_conversation', 'user_id', 'content', 'type', 'status', 'created_at'], 'required'],
            [['id_conversation', 'user_id', 'status'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ic_conversation' => 'Ic Conversation',
            'user_id' => 'User ID',
            'content' => 'Content',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public static function getUser($id){
        return User::findOne($id);
    }
}
