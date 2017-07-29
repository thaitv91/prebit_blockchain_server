<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sh_withdraw".
 *
 * @property integer $id
 * @property integer $id_shtransfer
 * @property integer $amount
 * @property integer $created_at
 */
class ShWithdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_withdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_shtransfer', 'amount', 'created_at'], 'required'],
            [['id_shtransfer', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_shtransfer' => 'Id Shtransfer',
            'amount' => 'Amount',
            'created_at' => 'Created At',
        ];
    }
}
