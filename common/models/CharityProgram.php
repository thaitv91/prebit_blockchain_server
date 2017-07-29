<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;
/**
 * This is the model class for table "charity_program".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $startday
 * @property integer $endday
 * @property integer $amount
 * @property string $note
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class CharityProgram extends \yii\db\ActiveRecord
{
    const STATUS_ACITVE = 0;
    const STATUS_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 0;
    const PUBLISH_NOACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charity_program';
    }

    /**
     * @inheritdoc
     */
    public $file;

    public function rules()
    {
        return [
            [['title', 'content', 'startday', 'endday', 'amount', 'note'], 'required'],
            [['file'],'file'],

            // [['content', 'note'], 'string'],
            // [['amount', 'status', 'publish', 'created_at', 'updated_at'], 'integer'],
            [['feature_images'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'startday' => 'Startday',
            'endday' => 'Endday',
            'amount' => 'Amount',
            'note' => 'Note',
            'file' => 'Feature Images',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getDonate($id) // Phuc
    {
        return CharityDonors::find()->where(['charity_program_id' => $id])->sum('amount');        
    }
    
}
