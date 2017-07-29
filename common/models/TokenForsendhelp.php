<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token_forsendhelp".
 *
 * @property integer $id
 * @property integer $token
 * @property double $min_amount
 * @property double $max_amount
 * @property integer $created_at
 */
class TokenForsendhelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token_forsendhelp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'min_amount', 'max_amount', 'created_at'], 'required'],
            [['token', 'created_at'], 'integer'],
            [['min_amount', 'max_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'min_amount' => 'Min Amount',
            'max_amount' => 'Max Amount',
            'created_at' => 'Created At',
        ];
    }
}
