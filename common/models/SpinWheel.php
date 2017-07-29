<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "spin_wheel".
 *
 * @property integer $id
 * @property integer $id_gift
 * @property integer $id_luckywheel
 * @property integer $number_order
 */
class SpinWheel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spin_wheel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_gift', 'id_luckywheel'], 'required'],
            [['id_gift', 'id_luckywheel', 'number_order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_gift' => 'Id Gift',
            'id_luckywheel' => 'Id Luckywheel',
            'number_order' => 'Number Order',
        ];
    }

    public static function getGift($id){
        return ListGift::findOne($id);
    }
}
