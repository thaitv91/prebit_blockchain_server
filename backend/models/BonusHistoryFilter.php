<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\BonusHistory;

class BonusHistoryFilter extends Model {

    public $username;
    public $fromday;
    public $today;
    /**
     * @inheritdoc
     */
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

    	$data = array();
        $users =  User::find()->where(['LIKE', 'username', $username])->all();
        foreach ($users as $key => $user) {
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