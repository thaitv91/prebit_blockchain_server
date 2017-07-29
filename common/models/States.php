<?php

namespace common\models;

use Yii;
use common\models\Countries;
use common\models\Cities;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "states".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * @property integer $postcode
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class States extends ActiveRecord
{
    const PUBLISH_ACTIVE = 1; 
    const PUBLISH_NONEACTIVE = 0; 

    
    public static function tableName()
    {
        return 'states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'name', 'postcode'], 'required'],
            //[['country_id', 'postcode', 'publish', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'postcode' => 'Postcode',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getFindBudget()
    {
        return $this->hasOne(Countries::className(), ['_id' => 'country_id']);
    }

    public function getCities() {
        return Cities::find()->where(['state_id' => $this->id])->all();
    }
}
