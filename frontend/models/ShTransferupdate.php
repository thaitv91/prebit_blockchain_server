<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use common\models\ShTransfer;

/**
 * Signup form
 */
class ShTransferupdate extends ShTransfer {

    public $status;
    public $inc_days;

    public function rules() {
        return [
     
        ];
    }

}
