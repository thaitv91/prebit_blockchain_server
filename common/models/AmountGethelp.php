<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "amount_gethelp".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $amount
 */
class AmountGethelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'amount_gethelp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'required'],
            [['level', 'amountsh', 'amountgh'], 'integer'],
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
            'amountsh' => 'Amount sh',
            'amountgh' => 'Amount gh',
        ];
    }
}
