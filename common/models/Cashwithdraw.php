<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Currency;

/**
 * This is the model class for table "cashwithdraw".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $currency
 * @property string $bank_name
 * @property string $recepient_name
 * @property integer $bank_account
 * @property string $bank_branch
 * @property string $swiftcode
 * @property string $additional_detail
 * @property double $amount
 * @property integer $status
 * @property integer $created_at
 */
class Cashwithdraw extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 1;
    const STATUS_COMPLETED = 2;

    const PUBLISH_PENDING = 1;
    const PUBLISH_COMPLETED = 2;

    public $getcurrency;
    public static function tableName()
    {
        return 'cashwithdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency', 'bank_name', 'recepient_name', 'bank_account', 'bank_branch', 'swiftcode', 'additional_detail', 'amount'], 'required'],
            [['user_id', 'currency', 'status', 'publish', 'created_at'], 'integer'],
            [['amount', 'otpcode'], 'number'],
            [['bank_name', 'bank_account', 'recepient_name', 'bank_branch', 'swiftcode', 'additional_detail'], 'string', 'max' => 255],
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
            'currency' => 'Country',
            'bank_name' => 'Bank Name',
            'recepient_name' => 'Recepient Name',
            'bank_account' => 'Bank Account',
            'bank_branch' => 'Bank Branch',
            'swiftcode' => 'Swiftcode',
            'additional_detail' => 'Additional Detail',
            'amount' => 'Amount',
            'amount_convert' => 'Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function getListCurrency()
    {
        $currency = Currency::find()->orderBy(['country'=>SORT_ASC])->all();
        $data = array();
        $data[''] = 'Select country';
        foreach ($currency as $key => $value) {
            $data[$value['id']] = $value['country'];
        }
        return $data;
    }

    public static function getUser($id){
        return User::findOne($id);
    }

    public static function getCurrency($id){
        return Currency::findOne($id);
    }
}
