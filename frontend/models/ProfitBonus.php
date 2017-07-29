<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ProfitBonus extends User {

    public $manager_bonus;
    public $referall_bonus;

    public function rules() {
        return [
            [['manager_bonus', 'referral_bonus'], 'required'],
        ];
    }

}
