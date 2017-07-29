<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\TicketTransfer;
use common\models\User;

class TicketFilter extends Model {

    public $username;
    public $fromday;
    public $today;


    public function rules() {
        return [
            [['username', 'fromday', 'today'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
        ];
    }

    public static function getUser($username){
        $user = User::find()->where(['LIKE', 'username', $username])->all();
        $data = array();
        foreach ($user as $key => $user) {
            $data[] .= $user->id;
        }
        return $data;
    }

}
