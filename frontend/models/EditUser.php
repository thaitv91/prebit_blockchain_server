<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;


class EditUser extends User
{
    public $fullname;
    public $address;
    public $state_id;
    public $city_id;
    public $birthday;
    public $country_id;
    public $postcode;
    public $sex;
    public $passport_id;
    public $phone;

    public function rules()
    {
        return [

            [['fullname', 'address', 'state_id', 'city_id', 'birthday', 'country_id'], 'string'],
            [['postcode', 'sex', 'passport_id', 'phone'], 'integer'],
        ];
    }
}

