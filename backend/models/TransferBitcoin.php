<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class TransferBitcoin extends Model {

    public $address;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['address', 'amount'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
        ];
    }

    public static function getUser($username){
        return User::find()->where(['username'=> $username])->one();
    }

}
