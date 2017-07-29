<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_code
 * @property string $language
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class Countries extends ActiveRecord
{
    const PUBLISH_ACTIVE = 1; 
    const PUBLISH_NONEACTIVE = 0; 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_code'], 'required'],
            ['name', 'unique', 'targetAttribute' => 'name', 'message' => 'This {attribute} already exists in the system!'],
            [['name'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'country_code' => 'Country Code',
            'language' => 'Language',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getStates() {
        return States::find()->where(['country_id' => $this->id])->all();
    }
    public function uniqueCountry($name)
    {
        $count = Countries::find()->where(['name'=>$name])->count();
        if($count > 0){
            $this->addError($attribute, 'Email already exists!');
        }else{

        }
    }

    
}
