<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;
/**
 * This is the model class for table "charity_donors".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $charity_program_id
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class CharityDonors extends \yii\db\ActiveRecord
{
    const STATUS_DONATE_ACTIVE = 1;
    const STATUS_DONATE_NOACTIVE = 0;
    public $sumamount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charity_donors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'charity_program_id'], 'required'],
            // [['user_id', 'amount', 'charity_program_id', 'status', 'created_at', 'updated_at'], 'integer'],
            // [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'charity_program_id' => 'Charity Program ID',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getProgram()
    {
        return $this->hasOne(CharityProgram::className(), ['id' => 'charity_program_id']);
    }
    public static function getDonate($id) // Phuc
    {
        return CharityDonors::find()->where(['user_id' => $id])->sum('amount');        
    }
}
