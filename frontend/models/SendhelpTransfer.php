<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use common\models\ShTransfer;

/**
 * Signup form
 */
class SendhelpTransfer extends ShTransfer {

    public $amount;

    public function rules() {
        return [
            [['amount'], 'required'],
            ['amount', 'number', 'min' => 0.05],
        ];
    }


}
