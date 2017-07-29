<?php

namespace frontend\models;

use common\models\User;
use common\models\GhTransfer;
use yii\base\Model;
use Yii;
use common\models\Country;
use common\models\Cities;

/**
 * Signup form
 */
class GhBonuswallet extends GhTransfer {

    public $user_id;
    public $amount;
    public $status;
    public $publish;
    public $created_at;
    public $updated_at;

    public function rules() {
        return [
            [['amount',], 'required', 'message' => 'This field is required!'],
            ['amount', 'number', 'min' => 0.005],
        ];
    }

    public function validateAmount()
    {
        if ($this->amount <= 0) {
            $this->addError('amount', 'Amount must be greater than 0!');
        }
    }
}
