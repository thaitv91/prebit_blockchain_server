<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;
use common\models\CharityLevel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CharitydonorsController extends FrontendController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('charitydonnors/index'));
        }
        $this->canUser();
    	$model = CharityProgram::find()->where(['publish' => CharityProgram::PUBLISH_ACTIVE])->orderBy(['endday' => SORT_DESC])->all();
        
        return $this->render('index',[
        	'model' => $model,
    	]);
    }
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('charitydonnors/index'));
        }
        $this->canUser();
        $model = CharityProgram::find()->all();
        $donors = new CharityDonors;
        $listdonors = CharityDonors::find()->where(['charity_program_id' => $id])->orderBy(['amount' => SORT_DESC])->all();
        $user = User::find()->all();
        return $this->render('view', [
            'model'     => $this->findModel($id),
            'donors'    => $donors,
            'user'    => $user,
            'listdonors'    => $listdonors,
        ]);
    }
    public function actionDonate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $charity = new CharityDonors;
        $model = CharityDonors::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->all();
        $wallet = Yii::$app->user->identity->wallet;
        $current_amount = ($_POST['current_amount']);
        $charity->user_id = Yii::$app->user->identity->id;
        $charity->charity_program_id = $_POST['id_program'];
        $charity->amount = $current_amount;
        $charity->created_at = time();
        $charity->updated_at = time();

        $charity->status = CharityDonors::STATUS_DONATE_ACTIVE;
        if ($charity->save()) 
        {
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->wallet = $user->wallet - $current_amount;
            $total_donate = CharityDonors::find()->where(['user_id' => $user->id])->sum('amount');
            $level = CharityLevel::find()->where(['>=', 'amount', $total_donate])->orderBy(['level'=>SORT_ASC])->limit(1)->all();
            foreach ($level as $key => $value) {
                $user->charity = $value->level;
            }
            $user->save();
            Yii::$app->session->setFlash('success', 'Donation completed successfully !');            
        }
        return $this->redirect(['view', 'id' => $_POST['id_program'],
            'model' => $model,
        ]);   
    }    
    protected function findModel($id)
    {
        if (($model = CharityProgram::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
