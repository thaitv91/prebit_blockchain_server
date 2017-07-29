<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "token_request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $mode
 * @property integer $status
 * @property integer $publish
 * @property integer $otp_code
 * @property integer $created_at
 * @property integer $updated_at
 */
class TokenRequest extends \yii\db\ActiveRecord
{
    const MODE_BUY   = 1; //buy token
    const MODE_TRANS = 2; //transfer token
    const MODE_GH = 3; //token for gethelp
    const MODE_SH = 4; //token for sendhelp

    const STA_PED  = 1; // status pending
    const STA_COMP = 2; //status completed

    const PUB_NOACTIVE = 1; //publish noactive
    const PUB_ACTIVE   = 2; //publish active


    public static function tableName()
    {
        return 'token_request';
    }

    public function rules()
    {
        return [
            [['amount'], 'required'],
            [['bitcoin'],'integer', 'integerOnly' => false,],
            ['amount', 'validateAmount']
            //['reciever', 'exist', 'targetClass' => '\common\models\User', 'targetAttribute' => 'username', 'message' => 'This {attribute} does not exists in the system!'],
        ];
    }

    public function validateAmount()
    {
        if ($this->amount <= 0) {
            $this->addError('amount', 'Amount should be greater than 0!');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'bitcoin' => 'Bitcoin',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'reciever' => 'Reciever',
            'mode' => 'Mode',
            'publish' => 'Publish',
            'otp_code' => 'Otp Code',
            'created_at' => 'Created At',
        ];
    }

    public static function getUser($id){
        return User::findOne($id);
    }
}
