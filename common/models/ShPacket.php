<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sh_packet".
 *
 * @property integer $id
 * @property integer $min_days
 * @property integer $max_days
 * @property integer $min_amount
 * @property integer $max_amount
 * @property integer $daily_profit
 * @property integer $level
 * @property integer $token
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShPacket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_packet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_days', 'max_days', 'min_amount', 'max_amount', 'created_at'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_days' => 'Min Days',
            'max_days' => 'Max Days',
            'min_amount' => 'Min Amount',
            'max_amount' => 'Max Amount',
            'created_at' => 'Created At',
        ];
    }
}
