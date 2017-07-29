<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\BonusHistory;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReferralsbonusController extends FrontendController
{
    public function actionIndex()
    {
    	if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('referralsbonus/index'));
        }
        $this->canUser();

        $id = Yii::$app->user->identity->id;
    	$query = BonusHistory::find()->where(['reciever_id'=>$id, 'wall_type'=>BonusHistory::REFERRAL_BONUS])->orderBy(['created_at'=>SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $query,
            'pagination' => [
                'pageSize' => 10,

            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
