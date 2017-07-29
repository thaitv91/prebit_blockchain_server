<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class WithdrawBitcoin extends Model
{
    public $btcaddress;
    public $amount;

    public function rules()
    {
        return [
            //[['btcaddress', 'amount'], 'required'],
        ];
    }

}
