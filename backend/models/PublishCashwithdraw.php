<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Cashwithdraw;

class PublishCashwithdraw extends Cashwithdraw {

    public $publish;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['username', 'amount'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
        ];
    }


}