<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use common\models\Country;
use common\models\Cities;

/**
 * Signup form
 */
class RegisterForm extends User {

    public $referral_id;
    public $fullname;
    public $slugname;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $country;
    public $phone;
    public $accept;

    public function rules() {
        return [
            [['fullname', 'email'], 'filter', 'filter' => 'trim'],
            [['fullname', 'username', 'email', 'password', 'country', 'phone'], 'required', 'message' => 'This field is required!'],
            ['referral_id', 'exist', 'targetAttribute' => 'username', 'message' => 'This {attribute} does not exists in the system!'],
            ['username', 'unique', 'targetAttribute' => 'username', 'message' => 'This {attribute} already exists in the system!'],
            ['username', 'string', 'min' => 4, 'tooShort' => 'Username must be over 4 characters!'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => 'This {attribute} already exists in the system!'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Phone number must be integer'],
            ['phone', 'number', 'message' => 'Phone number must be integer'],
            ['phone', 'string', 'min' => 6, 'max' => 11, 'tooShort' => 'Phone number be between 6 and 11 digits', 'tooLong' => 'Phone number be between 6 and 11 digits!'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This {attribute} already exists in the system!'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Passwords must be over 6 characters!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'The passwords do not match!'],   
            ['username', 'validateUsername'],    
            ['password', 'validatePassword'],       
        ];
    }

    public function validateUsername()
    {
        if (preg_match('/\s+/',$this->username)) {
            $this->addError('username', 'No white spaces allowed!');
        }
        // if (strlen($this->username) != strlen(utf8_decode($this->username)))
        // {
        //     $this->addError('username', 'Username not unicode!');
        // }
    }
public function validatePassword($password)    {
        if (preg_match('/\s+/',$this->password)) {
            $this->addError('password', 'No white spaces allowed!');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referral_id' => 'Referral Username',
            'username' => 'Username',
        ];
    }

    public function getQuestionList() {
        $models = Questions::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['content'];
            }
        }
        return $data;
    }

    public function getCityList() {
        $models = City::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }



}
