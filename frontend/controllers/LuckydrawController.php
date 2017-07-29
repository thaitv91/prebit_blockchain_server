<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\LuckyWheel;
use common\models\ListGift;
use common\models\GiftLuckywheel;
use common\models\GiftUser;
use common\models\SpinWheel;
use common\models\TicketTransfer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LuckydrawController extends FrontendController
{
	public function actionIndex()
    {
    	$LuckyWheel = LuckyWheel::find()->where(['publish'=>LuckyWheel::PUBLISH_ACTIVE])->andWhere(['<=', 'start', time()])->andWhere(['>=', 'finish', time()])->orderBy(['created_at'=>SORT_ASC])->one();
    	if(!empty($LuckyWheel)){
    		$User = User::findOne(Yii::$app->user->identity->id);
            $user_winers = GiftUser::find()->where(['id_luckywheel' => $LuckyWheel->id])->orderBy(['created_at'=>SORT_DESC])->all();
            $user_gift = GiftUser::find()->where(['user_id' => $User->id])->orderBy(['created_at'=>SORT_DESC])->all();
    		$GiftLuckywheel = GiftLuckywheel::find()->where(['id_luckywheel' => $LuckyWheel->id])->all();
    		$SpinWheel = SpinWheel::find()->where(['id_luckywheel' => $LuckyWheel->id])->orderBy(['number_order'=>SORT_ASC])->all();
    		return $this->render('index',[
    			'User' => $User,
	        	'LuckyWheel' => $LuckyWheel,
	        	'GiftLuckywheel' => $GiftLuckywheel,
	        	'SpinWheel' => $SpinWheel,
                'user_winers' => $user_winers,
                'user_gift' => $user_gift,
	        ]);
    	} else {
            $User = User::findOne(Yii::$app->user->identity->id);
            $user_gift = GiftUser::find()->where(['user_id' => $User->id])->orderBy(['created_at'=>SORT_DESC])->all();
    		return $this->render('empty', [
                'user_gift' => $user_gift,
            ]);
    	}
    }


    //minus ticket of user when spin wheel
    public function actionMinusticket(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findOne($_POST['user']);

        $ticketTransfer = new TicketTransfer;
        $ticketTransfer->user_id = $user->id;
        $ticketTransfer->amount = 1;
        $ticketTransfer->bitcoin = 0;
        $ticketTransfer->mode = TicketTransfer::MODE_USE;
        $ticketTransfer->otp_code = 0;
        $ticketTransfer->lucky_id = $_POST['luckywheel'];
        $ticketTransfer->status = TicketTransfer::STATUS_ACTIVE;
        $ticketTransfer->created_at = time();
        $ticketTransfer->save();

        $user->ticket = $user->ticket - 1;
        if($user->save()){
        	return 'ok';
        }

        
    }

    //save result spin wheel
    public function actionSpinwheel(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findOne($_POST['user']);
        $gift = ListGift::findOne($_POST['gift']);
        $luckywheel = LuckyWheel::findOne($_POST['luckywheel']);
        
        $giftLuckywheel = GiftLuckywheel::find()->where(['id_gift' => $gift->id])->one();
        //check quatity of gift in luckywheel
        if($giftLuckywheel->quatity > 0){
            $giftUser = new GiftUser;
            $giftUser->user_id = $user->id;
            $giftUser->id_gift = $gift->id;
            $giftUser->id_luckywheel = $luckywheel->id;
            $giftUser->status = GiftUser::STATUS_NOACTIVE;
            $giftUser->created_at = time();
            if($giftUser->save()){
                $giftLuckywheel->quatity = $giftLuckywheel->quatity - 1;
                $giftLuckywheel->save();
                return 'Congratulations you have won 1 '.$gift->name;
            }
        } else {
            return 'This award was effete wish you good luck next time!';
        }
    }
}
