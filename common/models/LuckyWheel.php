<?php

namespace common\models;

use Yii;


class LuckyWheel extends \yii\db\ActiveRecord
{

    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function tableName()
    {
        return 'lucky_wheel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start', 'finish'], 'required'],
            [['publish', 'status', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start' => 'Start',
            'finish' => 'Finish',
            'publish' => 'Publish',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
