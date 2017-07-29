<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $floor
 * @property integer $created_at
 * @property integer $updated_at
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'floor', 'created_at', 'updated_at'], 'required'],
            [['level', 'floor', 'created_at', 'updated_at'], 'integer'],
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
            'floor' => 'Floor',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
