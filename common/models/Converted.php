<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "converted".
 *
 * @property integer $id
 * @property string $object
 * @property double $value
 */
class Converted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'converted';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object', 'value'], 'required'],
            [['value'], 'number'],
            [['object'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object' => 'Object',
            'value' => 'Value',
        ];
    }
}
