<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ticket_transfer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $mode
 * @property integer $otp_code
 * @property integer $lucky_id
 * @property integer $status
 * @property integer $created_at
 */
class TicketTransfer extends \yii\db\ActiveRecord
{
    const MODE_BUY = 1;
    const MODE_USE = 2;

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;


    public static function tableName()
    {
        return 'ticket_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_id', 'amount'], 'required'],
            [['user_id', 'amount', 'mode', 'otp_code', 'lucky_id', 'status', 'created_at'], 'integer'],
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
            'amount' => 'Amount',
            'bitcoin' => 'Bitcoin',
            'mode' => 'Mode',
            'otp_code' => 'Otp Code',
            'lucky_id' => 'Lucky ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public static function getUser($id){
        return User::findOne($id);
    }
}
