<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $content
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content', 'status', 'publish', 'created_at'], 'required'],
            [['user_id', 'status', 'publish', 'created_at'], 'integer'],
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
            'user_id' => 'User ID',
            'content' => 'Content',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getListUser()
    {
        $user = User::find()->all();
        $data = [];
        foreach ($user as $key => $value) {
            $data[$value['id']] = $value['username'];
        }
        return $data;
    }
    
}
