<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\GhTransfer;
use common\models\User;

class GhTransferFilter extends Model {

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
        return $data = array('' => 'Status', GhTransferFilter::STATUS_PENDING => 'PENDING', GhTransferFilter::STATUS_COMPLETED => 'COMPLETED');
    }

    public static function getUser($username){
        $user = User::find()->where(['LIKE', 'username', $username])->all();
        $data = array();
        foreach ($user as $key => $user) {
            $data[] .= $user->id;
        }
        return $data;
    }
	public static function getUserNotjap(){
        $user = User::find()->where(['<>', 'country_id', '23'])->all();
        $data = array();
        foreach ($user as $key => $user) {
            $data[] .= $user->id;
        }
        return $data;
    }

}
