<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use	yii\base\Configurable;
use common\models\TokenRequest;
use common\models\User;

/**
 * Login form
 */
class TransferToken extends TokenRequest
{
	public $user_id;
    public $reciever;
    public $amount_token;

    public function rules()
    {
        return [
            [['reciever', 'amount_token',], 'required'],
            ['reciever', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'username'],
            ['amount_token', 'validateAmount'],
        ];
    }

    public function validateAmount()
    {
        if ($this->amount_token <= 0) {
            $this->addError('amount_token', 'Amount must be greater than 0!');
        }
    }

}
