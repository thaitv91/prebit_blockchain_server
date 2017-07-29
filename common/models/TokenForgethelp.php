<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token_forgethelp".
 *
 * @property integer $id
 * @property integer $token
 * @property double $min_mainw
 * @property double $max_mainw
 * @property double $min_bonusw
 * @property double $max_bonusw
 * @property integer $created_at
 */
class TokenForgethelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token_forgethelp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'min_mainw', 'max_mainw', 'min_bonusw', 'max_bonusw', 'created_at'], 'required'],
            [['token', 'created_at'], 'integer'],
            [['min_mainw', 'max_mainw', 'min_bonusw', 'max_bonusw'], 'number'],
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
            'min_mainw' => 'Min Mainw',
            'max_mainw' => 'Max Mainw',
            'min_bonusw' => 'Min Bonusw',
            'max_bonusw' => 'Max Bonusw',
            'created_at' => 'Created At',
        ];
    }
}
