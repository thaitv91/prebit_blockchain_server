<?php

namespace common\models;

use Yii;
use common\models\Countries;

/**
 * This is the model class for table "buy_btc".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $address
 * @property integer $created_at
 */
class BuyBtc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buy_btc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'address'], 'required'],
            [['country_id', 'created_at'], 'integer'],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'address' => 'Address',
            'created_at' => 'Created At',
        ];
    }

    public function getListCountry(){
        $countries = Countries::find()->all();
        foreach ($countries as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }

    public static function findCountry($id){
        return Countries::findOne($id);
    }
}
