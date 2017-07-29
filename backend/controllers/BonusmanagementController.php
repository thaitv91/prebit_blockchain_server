<?php
namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\User;
use common\models\BonusHistory;
use backend\models\BonusHistoryFilter;


/**
 * Site controller
 */
class BonusmanagementController extends BackendController
{
	public function actionReferralbonus()
    {
        $ip   = $_SERVER['REMOTE_ADDR'];
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
		$country=$details->geoplugin_countryCode;
		if($country==="JP"){
		throw new NotFoundHttpException('The requested page does not exist.');
		}
		$bonushistoryfilter = new BonusHistoryFilter;

        $query = BonusHistory::find();
        if ($bonushistoryfilter->load(Yii::$app->request->get())) {
            $query->where(['wall_type'=>BonusHistory::REFERRAL_BONUS])->orderBy(['created_at'=>SORT_DESC]);

            if(!empty($bonushistoryfilter->username)){
                $query->andWhere(["IN","reciever_id", $bonushistoryfilter->getUser($bonushistoryfilter->username)]);
            }

            if(!empty($bonushistoryfilter->fromday)){
                $date=date_create($bonushistoryfilter->fromday);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($bonushistoryfilter->today)){
                $date=date_create($bonushistoryfilter->today);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }
        }else{
            $query->where(['wall_type'=>BonusHistory::REFERRAL_BONUS])->orderBy(['created_at'=>SORT_DESC]);
			
        }
        $query->andWhere(["IN", "user_id", $bonushistoryfilter->getUserNotjap()]);
        $model = $query->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20,

            ],
        ]);

        return $this->render('referralbonus', [
            'dataProvider' => $dataProvider,
            'bonushistoryfilter' => $bonushistoryfilter,
        ]);
    }


    public function actionManagerbonus()
    {
        $ip   = $_SERVER['REMOTE_ADDR'];
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
		$country=$details->geoplugin_countryCode;
		if($country==="JP"){
		throw new NotFoundHttpException('The requested page does not exist.');
		}
		$bonushistoryfilter = new BonusHistoryFilter;

        $query = BonusHistory::find();
        if ($bonushistoryfilter->load(Yii::$app->request->get())) {
            $query->where(['wall_type'=>BonusHistory::MANAGER_BONUS])->orderBy(['created_at'=>SORT_DESC]);

            if(!empty($bonushistoryfilter->username)){
                $query->andWhere(["IN","reciever_id", $bonushistoryfilter->getUser($bonushistoryfilter->username)]);
            }

            if(!empty($bonushistoryfilter->fromday)){
                $date=date_create($bonushistoryfilter->fromday);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">", "created_at", $datefrom]);
            }
            if(!empty($bonushistoryfilter->today)){
                $date=date_create($bonushistoryfilter->today);
                $dateto = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere(["<", "created_at", $dateto]);
            }
        }else{
            $query->where(['wall_type'=>BonusHistory::MANAGER_BONUS])->orderBy(['created_at'=>SORT_DESC]);
			
        }
        $query->andWhere(["IN", "user_id", $bonushistoryfilter->getUserNotjap()]);
        $model = $query->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20,

            ],
        ]);

        return $this->render('referralbonus', [
            'dataProvider' => $dataProvider,
            'bonushistoryfilter' => $bonushistoryfilter,
        ]);
    }

    
}
?>