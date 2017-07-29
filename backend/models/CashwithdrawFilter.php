<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Cashwithdraw;
use common\models\User;

class CashwithdrawFilter extends Model {

    public $username;
    public $fromday;
    public $today;
    public $status;

    const STATUS_PENDING = 1;
    const STATUS_COMPLETED = 2;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'fromday', 'today', 'status'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
        ];
    }

    public function getListStatus(){
        return $data = array('' => 'Status', CashwithdrawFilter::STATUS_PENDING => 'PENDING', CashwithdrawFilter::STATUS_COMPLETED => 'COMPLETED');
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
