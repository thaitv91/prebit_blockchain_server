<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sh_transfer_id
 * @property integer $amount
 * @property integer $balance
 * @property integer $wall_type
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class BonusHistory extends \yii\db\ActiveRecord
{
    const MANAGER_BONUS = 1;
    const REFERRAL_BONUS = 2;


    public static function tableName()
    {
        return 'bonus_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'reciever_id', 'sh_transfer_id', 'amount'], 'required'],
            [['user_id', 'reciever_id', 'sh_transfer_id', 'wall_type', 'status', 'publish', 'created_at', 'updated_at'], 'integer'],
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
            'reciever_id' => 'Reciever ID',
            'sh_transfer_id' => 'Sh Transfer ID',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'wall_type' => 'Wall Type',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findUserbyid($id){
        return User::findOne($id);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getReciever()
    {
        return $this->hasOne(User::className(), ['id' => 'reciever_id']);
    }
}
