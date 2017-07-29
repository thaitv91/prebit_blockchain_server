<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class GetTicket extends Model {

    public $username;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'amount'], 'required'],
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
