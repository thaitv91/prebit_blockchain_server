<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "charity_level".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $amount
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class CharityLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charity_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'required'],
            [['level', 'publish', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'amount' => 'Amount',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
