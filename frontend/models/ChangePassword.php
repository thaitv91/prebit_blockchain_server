<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePassword extends User {

    public $password;
    public $password_repeat;

    public function rules() {
        return [
            [['password', 'password_repeat'], 'required', 'message' => 'This field is required!'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Passwords must be over 6 characters!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'The passwords do not match!'],     
            ['password', 'validatePassword'],       
        ];
    }

    public function validatePassword($password)
    {
        if (preg_match('/\s+/',$this->password)) {
            $this->addError('password', 'No white spaces allowed!');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password' => 'New Password',
            'password_repeat' => 'Confirm New Password',
        ];
    }

}
