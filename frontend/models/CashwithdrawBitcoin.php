<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Countries;
use common\models\Currency;

/**
 * Login form
 */
class CashwithdrawBitcoin extends Model
{
    public $country;
    public $currency;
    public $bankname;
    public $recepientname;
    public $bankaccountnumber;
    public $bankbranchname;
    public $swiftcode;
    public $additionaldetails;
    public $amount;

    public function rules()
    {
        return [
            [['country', 'bankname', 'recepientname', 'bankaccountnumber', 'bankbranchname', 'swiftcode', 'additionaldetails', 'amount'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'country' => 'Country',
            'bankname' => 'Bank name',
            'recepientname' => 'Recepient Name',
            'bankaccountnumber' => 'Bank account number',
            'bankbranchname' => 'Bank branch name',
            'swiftcode' => 'Swift code',
            'additionaldetails' => 'Additional details',
            'amount' => 'Amount',
        ];
    }

    public function getListCurrency()
    {
        $currency = Currency::find()->all();
        $data = array();
        $data[''] = 'Select country';
        foreach ($currency as $key => $value) {
            $data[$value['id']] = $value['country'];
        }
        return $data;
    }
}
