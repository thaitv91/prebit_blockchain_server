<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "referral_bonus".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $profit
 * @property integer $created_at
 * @property integer $updated_at
 */
class ReferralBonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referral_bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'required'],
            [['level', 'created_at', 'updated_at'], 'integer'],
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
            'level' => 'Level',
            'profit' => 'Profit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findUserbyid($id){
        return User::findOne($id);
    }
}
