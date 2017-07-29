<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manager_bonus".
 *
 * @property integer $id
 * @property integer $floor
 * @property integer $profit
 * @property integer $created_at
 * @property integer $updated_at
 */
class ManagerBonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager_bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floor', 'profit', 'created_at', 'updated_at'], 'required'],
            [['floor', 'created_at', 'updated_at'], 'integer'],
            [['profit'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'floor' => 'Floor',
            'profit' => 'Profit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
