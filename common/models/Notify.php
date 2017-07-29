<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notify".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $receive_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */

class Notify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const PUBLISH_ACTIVE = 1; 
    const PUBLISH_NOACTIVE = 0;
    const STATUS_ADMIN = 1; // Message ADmin send user
    const STATUS_USER = 0; // Message User send Admin
    const ADMIN_ID = 0;
    const ALL_NUM = 22; // CHUNG CUA 2 MESSAGE

    public static function tableName()
    {
        return 'notify';
    }
    public $file;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receive_id', 'title', 'content'], 'required'],
            [['all_id','user_id', 'receive_id', 'status', 'publish', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['file'],'file'],
            [['attach_file'], 'string', 'max' => 255],
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
            'receive_id' => 'Receive ID',
            'all_id' => 'ALL ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public static function findAvatar($id){
        $notify = Notify::findOne($id);
        return User::findOne($notify->user_id);
    }
}
    
