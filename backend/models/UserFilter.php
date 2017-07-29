<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\LevelSetting;
use common\models\Countries;

class UserFilter extends Model {

    public $username;
    public $fullname;
    public $phone;
    public $email;
    public $status;
    public $publish;
    public $level;
    public $shstatus;
    public $downline;
    public $country;
    public $dayto;
    public $dayfrom;
    public $dayfromsh;
    public $daytosh;


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'fullname', 'phone', 'email', 'status', 'publish', 'level', 'shstatus', 'downline', 'country', 'dayto', 'dayfrom', 'dayfromsh', 'daytosh'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
        ];
    }

    public function getListStatus(){
        return $data = array('' => 'All Status', User::STATUS_ACTIVE => 'ACTIVATED', User::STATUS_NOACTIVE => 'NO ACTIVATED');
    }

    public function getListPublish(){
        return $data = array('' => 'All Publish', User::PUBLISH_ACTIVE => 'VERIFY', User::PUBLISH_NOACTIVE => 'NO VERIFY');
    }

    public function getListShstatus(){
        return $data = array('' => 'All Status', User::SHSTATUS_NOACTIVE => 'WITHOUT SH', User::SHSTATUS_ACTIVE => 'ALREADY SH');
    }

    public function getListDownline(){
        return $data = array(User::ORDERBY_DOWNLINE_DESC => 'DOWNLINE HIGH TO LOW', User::ORDERBY_DOWNLINE_ASC => 'DOWNLINE LOW TO HIGH',);
    }

    public function getListLevel(){
        $levels = LevelSetting::find()->orderBy(['level'=>SORT_ASC])->all();
        $data = array();
        $data[] = 'All Level';
        foreach ($levels as $key => $level) {
            $data[$level['level']] = $level['level'];
        }
        return $data;
    }

    public static function getUser($username){
        return User::find()->where(['username'=>$username])->one();
    }

    public function getListCountry(){
        $countries = Countries::find()->where(['publish'=>Countries::PUBLISH_ACTIVE])->orderBy(['name'=>SORT_ASC])->all();
        $data = array();
		$data[] = 'All country';
        foreach ($countries as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }

}
