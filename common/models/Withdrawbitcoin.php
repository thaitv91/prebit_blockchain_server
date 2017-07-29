<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "withdrawbitcoin".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $btcaddress
 * @property double $amount
 * @property integer $otp_code
 * @property integer $status
 * @property integer $created_at
 */
class Withdrawbitcoin extends \yii\db\ActiveRecord
{
    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function tableName()
    {
        return 'withdrawbitcoin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['btcaddress', 'amount'], 'required'],
            [['user_id', 'status', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['btcaddress'], 'string', 'max' => 255],
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
            'btcaddress' => 'Bitcoin address',
            'amount' => 'Amount',
            'otp_code' => 'Otp Code',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
