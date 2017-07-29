<?php

namespace backend\controllers;

use Yii;
use common\models\TicketTransfer;
use common\models\User;
use backend\models\TicketFilter;
use backend\models\GetTicket;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashwithdrawController implements the CRUD actions for Cashwithdraw model.
 */
class TickettransferController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $ticketFilter = new TicketFilter;
        $query = TicketTransfer::find();

        if ($ticketFilter->load(Yii::$app->request->get())) {
            $query->where(['status'=>TicketTransfer::STATUS_ACTIVE])->orderBy(['created_at'=>SORT_DESC]);
            if(!empty($ticketFilter->username)){
                $query->andWhere(["IN", "user_id", $ticketFilter->getUser($ticketFilter->username)]);
            }
            if(!empty($ticketFilter->fromday)){
                $date=date_create($ticketFilter->fromday);
                $datefrom = strtotime(date_format($date,"m/d/Y"));
                $query->andWhere([">=", "created_at", $datefrom]);
            }
            if(!empty($ticketFilter->today)){
                $date=date_create($ticketFilter->today);
                $dateto = strtotime(date_format($date,"m/d/Y 23:59"));
                $query->andWhere(["<=", "created_at", $dateto]);
            }


        } else{
            $query->where(['status'=>TicketTransfer::STATUS_ACTIVE])->orderBy(['created_at'=>SORT_DESC]);
        }

        $model = $query->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'ticketFilter' => $ticketFilter,
        ]);
    }

    public function actionGetticket()
    {
        $getticket = new GetTicket;

        if ($getticket->load(Yii::$app->request->post())) {
            if(!empty($getticket->username)){
                $user = $getticket->getUser($getticket->username);
                if(empty($user)){
                    Yii::$app->getSession()->setFlash('alert_gettoken', 'Username does not exist!');
                    return $this->render('getticket',[
                        'getticket' => $getticket,
                    ]);
                }else{
                    $user->ticket = $user->ticket + $getticket->amount;
                    $user->save();
                    Yii::$app->getSession()->setFlash('alert_gettoken', ' '.$user->username.' has been added '.$getticket->amount.' to Ticket wallet!');
                    return $this->render('getticket',[
                        'getticket' => $getticket,
                    ]);
                }
            }
        }
        return $this->render('getticket',[
            'getticket' => $getticket,
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Cashwithdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
