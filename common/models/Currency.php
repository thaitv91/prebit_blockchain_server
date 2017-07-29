<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $country
 * @property string $currency
 * @property integer $publish
 * @property integer $created_at
 */
class Currency extends \yii\db\ActiveRecord
{
    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'currency'], 'required'],
            [['publish', 'created_at'], 'integer'],
            [['exchange_rate', 'fee'], 'number'],
            [['country'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'currency' => 'Currency',
            'exchange_rate' => 'Exchange rate',
            'fee' => 'Fee',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }
}
