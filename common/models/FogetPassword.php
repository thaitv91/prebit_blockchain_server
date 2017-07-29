<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Account;

/**
 * Login form
 */
class FogetPassword extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['email'], 'required', 'message' => '{attribute} không được rỗng'],
            ['email', 'email', 'message' => 'Email này không đúng.'],
            ['email', 'string', 'max' => 255],
        ];
    }
   
    public function attributeLabels() {
        return [
            'email' => 'Email',
        ];
    }
}
