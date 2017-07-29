<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property integer $state_id
 * @property string $name
 * @property integer $city_code
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cities extends \yii\db\ActiveRecord
{
    const PUBLISH_ACTIVE = 1; 
    const PUBLISH_NONEACTIVE = 0; 

    public static function tableName()
    {
        return 'cities';
    }

    public function rules()
    {
        return [
            [['state_id', 'name', 'city_code'], 'required'],
            //[['state_id', 'city_code', 'publish', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state_id' => 'State ID',
            'name' => 'Name',
            'city_code' => 'City Code',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    
}
