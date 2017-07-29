<?php

namespace common\models;
use yii\db\ActiveRecord;
use common\models\LevelSetting;
use yii\validators\UniqueValidator;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "level_setting".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $amount
 * @property integer $child
 * @property integer $child_level
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class LevelSetting extends ActiveRecord
{
    const PUB_NOACTIVE = 0; //publish no active
    const PUB_ACTIVE = 1; //publish active

    public static function tableName()
    {
        return 'level_setting';
    }

    public function rules()
    {
        return [
            [['level', 'amount', 'child', 'child_level', 'child_2', 'child_level_2', 'token', 'ticket', 'amount_sh'], 'required'],
            [['level', 'amount', 'child', 'child_level', 'child_2', 'child_level_2', 'manager_bonus', 'token', 'ticket', 'amount_sh', 'publish', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'amount' => 'Amount',
            'child' => 'Child',
            'child_level' => 'Child Level',
            'child_2' => 'Child 2',
            'child_level_2' => 'Child Level 2',
            'token' => 'Token gift monthly',
            'ticket' => 'Ticket gift monthly',
            'manager_bonus' => 'Floor manager bonus',
            'amount_sh' => 'amount sh permited',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function amountgethelp($id){
        return AmountGethelp::find()->where(['level'=>$id])->one();
    }
}
