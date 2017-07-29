<?php

namespace common\models;

use Yii;
use common\models\ListGift;

/**
 * This is the model class for table "gift_luckywheel".
 *
 * @property integer $id
 * @property integer $id_gift
 * @property integer $id_luckywheel
 * @property integer $quatity
 */
class GiftLuckywheel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gift_luckywheel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_gift', 'id_luckywheel', 'quatity'], 'required'],
            [['id_gift', 'id_luckywheel', 'quatity'], 'integer'],
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
            'quatity' => 'Quatity',
        ];
    }

    public static function getGift($id){
        return ListGift::findOne($id);
    }
}
