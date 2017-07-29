<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\ListGift;

/**
 * This is the model class for table "gift_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $id_gift
 * @property integer $id_luckywheel
 * @property integer $created_at
 */
class GiftUser extends \yii\db\ActiveRecord
{
    
    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function tableName()
    {
        return 'gift_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'id_gift', 'id_luckywheel', 'status', 'created_at'], 'required'],
            [['user_id', 'id_gift', 'id_luckywheel'], 'integer'],
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
            'id_gift' => 'Id Gift',
            'id_luckywheel' => 'Id Luckywheel',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGift(){
        return $this->hasOne(ListGift::className(), ['id' => 'id_gift']);
    }
}
