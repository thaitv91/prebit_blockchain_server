<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;



class Newsmanagement extends \yii\db\ActiveRecord {

    const PUBLISH_ACTIVE = 1;
    const PUBLISH_NOACTIVE = 2;

    public static function collectionName() {
        return 'newsmanagement';
    }

    public function rules() {
        return [
            [['title', 'description', 'content'], 'required', 'message' => '{attribute} is not empty'],
            [['description', 'content'], 'string'],
            // [['publish', 'view', 'created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributes()
    {
        return [
            'id',
            'title',
            'description',
            'content',
            'publish',
            'created_at',
            'updated_at',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
