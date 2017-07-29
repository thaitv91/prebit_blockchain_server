<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "converted".
 *
 * @property integer $id
 * @property string $object
 * @property double $value
 */
class TokenGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'number'],
            [['time'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        
    }


    // send token and ticket gift for user per monthly
    public function sendtokengift(){
        $time = date('m/Y', time());
        $gift = TokenGift::find()->where(['time'=>$time])->one();
        $token_gift =  new TokenGift;
        if(empty($gift)){
            $listusers = User::find()->where(['status'=>User::STATUS_ACTIVE])->all();
            foreach ($listusers as $key => $users) {
                $user = User::findOne($users->id);
                //get token for level
                $token = LevelSetting::find()->where(['level'=>$user->level])->one();
                //add token
                $user->token = $user->token + $token->token;
                //add ticket
                $user->ticket = $user->ticket + $token->ticket;

                $user->save();
            }
            $token_gift->time = $time;
            $token_gift->created_at = time();
            $token_gift->save();
        }
    }
}
