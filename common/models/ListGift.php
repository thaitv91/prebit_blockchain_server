<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "list_gift".
 *
 * @property integer $id
 * @property string $name
 * @property string $thumbnail
 * @property integer $publish
 * @property integer $created_at
 */
class ListGift extends \yii\db\ActiveRecord
{
    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    public static function tableName()
    {
        return 'list_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'thumbnail', 'color'], 'required'],
            [['publish', 'created_at'], 'integer'],
            [['name', 'thumbnail', 'color'], 'string', 'max' => 255],
            //[['thumbnail'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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
            'thumbnail' => 'Thumbnail',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $upload = $this->thumbnail->saveAs(str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT']).'/uploads/luckywheel/' . $this->thumbnail->baseName . '.' . $this->thumbnail->extension);
            return true;
        } else {
            return false;
        }
    }

    public function getColorpicker(){
        $data = array("#ac725e"=>"#ac725e", "#d06b64"=>"#d06b64", "#f83a22"=>"#f83a22", "#fa573c"=>"#fa573c", "#ff7537"=>"#ff7537", "#ffad46"=>"#ffad46", "#42d692"=>"#42d692", "#16a765"=>"#16a765", "#7bd148"=>"#7bd148", "#b3dc6c"=>"#b3dc6c", "#fbe983"=>"#fbe983", "#fad165"=>"#fad165", "#92e1c0"=>"#92e1c0", "#9fe1e7"=>"#9fe1e7", "#9fc6e7"=>"#9fc6e7", "#4986e7"=>"#4986e7", "#9a9cff"=>"#9a9cff", "#b99aff"=>"#b99aff", "#c2c2c2"=>"#c2c2c2", "#cabdbf"=>"#cabdbf", "#cca6ac"=>"#cca6ac", "#f691b2"=>"#f691b2", "#cd74e6"=>"#cd74e6", "#a47ae2"=>"#a47ae2", "#555"=>"#555");

        return $data;
    }
}
