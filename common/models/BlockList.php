<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "block_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 */
class BlockList extends \yii\db\ActiveRecord
{
    const BLOCK_NOACTIVE = 1;
    const BLOCK_ACTIVE = 2;


    public static function tableName()
    {
        return 'block_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
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
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }
}
