<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Countries;

class TokenFilter extends Model {

    public $username;
    public $dayfrom;
    public $dayto;
    public $country;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'country', 'dayfrom', 'dayto'], 'string'],
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
	public static function getUserNotjap(){
        $user = User::find()->where(['<>', 'country_id', '23'])->all();
        $data = array();
        foreach ($user as $key => $user) {
            $data[] .= $user->id;
        }
        return $data;
    }

    public static function getUserbycountry($country){
        $user = User::find()->where(['country_id' => $country])->all();
        $data = array();
        foreach ($user as $key => $user) {
            $data[] .= $user->id;
        }
        return $data;
    }

    public function getListCountry(){
        $countries = Countries::find()->where(['publish'=>Countries::PUBLISH_ACTIVE])->orderBy(['name'=>SORT_ASC])->all();
        $data = array();
        $data[''] = 'All contry';
        foreach ($countries as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }

}
