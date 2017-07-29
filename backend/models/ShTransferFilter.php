<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\ShTransfer;
use common\models\User;

class ShTransferFilter extends Model {

    public $username;
    public $fromday;
    public $today;
    public $status;

    const STATUS_GOING = 1;
    const STATUS_MATURITY = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_CANCELED = 4;
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
        return $data = array('' => 'Status', ShTransferFilter::STATUS_GOING => 'On going', ShTransferFilter::STATUS_MATURITY => 'Maturity', ShTransferFilter::STATUS_COMPLETED => 'Completed', ShTransferFilter::STATUS_CANCELED => 'Canceled');
    }

    public static function getUser($username){
        $user = User::find()->where(['LIKE', 'username', $username])->andWhere(['<>', 'country_id', '23'])->all();
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
