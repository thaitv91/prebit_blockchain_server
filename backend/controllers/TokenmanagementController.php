<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\TokenRequest;
use backend\models\TokenFilter;
use backend\models\GetToken;


/**
 * Site controller
 */
class TokenmanagementController extends BackendController
{
	public function actionIndex()
    {
        $ip   = $_SERVER['REMOTE_ADDR'];
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
		$country=$details->geoplugin_countryCode;
		if($country==="JP"){
		throw new NotFoundHttpException('The requested page does not exist.');
		}
		$tokenfilter = new TokenFilter;
        $query = TokenRequest::find();
        if ($tokenfilter->load(Yii::$app->request->get())) {
            $query->where(['mode' => TokenRequest::MODE_BUY]);
            if(!empty($tokenfilter->username)){
                $query->andWhere(["IN", "user_id", $tokenfilter->getUser($tokenfilter->username)]);
            }
            if(!empty($tokenfilter->country)){
                $query->andWhere(["IN", "user_id", $tokenfilter->getUserbycountry($tokenfilter->country)]);
            }
            if(!empty($tokenfilter->dayfrom)){
                $date=date_create($tokenfilter->dayfrom);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($tokenfilter->dayto)){
                $date=date_create($tokenfilter->dayto);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
				
            }
        }else{
            $query->where(['mode' => TokenRequest::MODE_BUY]);
			
        }
        $query->andWhere(["IN", "user_id", $tokenfilter->getUserNotjap()]);
        $model = $query->orderBy(['created_at' => SORT_DESC])->all();
        $total_bitcoin = $query->sum('amount');
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('index',[
        	'dataProvider' => $dataProvider,
            'tokenfilter' => $tokenfilter,
            'total_bitcoin' => $total_bitcoin,
        ]);
    }

    public function actionTransfer()
    {
        $tokenfilter = new TokenFilter;
        $query = TokenRequest::find();
        if ($tokenfilter->load(Yii::$app->request->get())) {
            $query->where(['mode' => TokenRequest::MODE_TRANS]);
            if(!empty($tokenfilter->username)){
                $query->andWhere(["IN", "user_id", $tokenfilter->getUser($tokenfilter->username)]);
            }
            if(!empty($tokenfilter->dayfrom)){
                $date=date_create($tokenfilter->dayfrom);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">", "created_at", $datefrom]);
            }
            if(!empty($tokenfilter->dayto)){
                $date=date_create($tokenfilter->dayto);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<", "created_at", $dateto]);
            }
        }else{
            $query->where(['mode' => TokenRequest::MODE_TRANS]);
        }

        $model = $query->orderBy(['created_at' => SORT_DESC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('tokentransfer',[
            'dataProvider' => $dataProvider,
            'tokenfilter' => $tokenfilter,
        ]);
    }

    public function actionGettoken()
    {
        $gettoken = new GetToken;

        if ($gettoken->load(Yii::$app->request->post())) {
            if(!empty($gettoken->username)){
                $user = $gettoken->getUser($gettoken->username);
                if(empty($user)){
                    Yii::$app->getSession()->setFlash('alert_gettoken', 'Username does not exist!');
                    return $this->render('gettoken',[
                        'gettoken' => $gettoken,
                    ]);
                }else{
                    $user->token = $user->token + $gettoken->amount;
                    $user->save();
                    Yii::$app->getSession()->setFlash('alert_gettoken', ' '.$user->username.' has been added '.$gettoken->amount.' to Token wallet!');
                    return $this->render('gettoken',[
                        'gettoken' => $gettoken,
                    ]);
                }
            }
        }
        return $this->render('gettoken',[
            'gettoken' => $gettoken,
        ]);

    }
}
?>