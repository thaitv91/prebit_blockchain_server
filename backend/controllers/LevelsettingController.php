<?php

namespace backend\controllers;

use Yii;
use common\models\LevelSetting;
use common\models\AmountGethelp;
use common\models\ProfitForsendhelp;
use common\models\CharityLevel;
use common\models\ReferralBonus;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LevelsettingController implements the CRUD actions for LevelSetting model.
 */
class LevelsettingController extends BackendController
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

    /**
     * Lists all LevelSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = LevelSetting::find()->orderBy(['level' => SORT_ASC])->all();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $query,
            'pagination' => [
                'pageSize' => 20
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new LevelSetting();
        if ($model->load(Yii::$app->request->post())) {

            $check = LevelSetting::find()->where(['level'=>$model->level])->count();
            if($check > 0){
                Yii::$app->session->setFlash('error', 'This level already exists');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            $model->created_at = time();
            $model->updated_at = time();
            $model->publish = LevelSetting::PUB_ACTIVE;
            if($model->save()){
                $findamountgethelp = AmountGethelp::find()->where(['level'=>$model->level])->one();
                if(empty($findamountgethelp)){
                    $amountgethelp = new AmountGethelp;
                    $amountgethelp->level = $model->level;
                    $amountgethelp->save();
                }
                
                $findcharity = CharityLevel::find()->where(['level'=>$model->level])->one();
                if(empty($findcharity)){
                    $charity = new CharityLevel;
                    $charity->level = $model->level;
                    $charity->save();
                }    

                $findreferral = ReferralBonus::find()->where(['level'=>$model->level])->one();
                if(empty($findreferral)){
                    $referral = new ReferralBonus;
                    $referral->level = $model->level;
                    $referral->created_at = time();
                    $referral->save();
                }    

                // $findprofitsh = ProfitForsendhelp::find()->where(['level'=>$model->level])->one();
                // if(empty($findprofitsh)){
                //     $profitsh = new ProfitForsendhelp;
                //     $profitsh->level = $model->level;
                //     $profitsh->created_at = time();
                //     $profitsh->save();
                // }    

                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($this->findModel($id)->level != $model->level){
                $check = LevelSetting::find()->where(['level'=>$model->level])->count();
                if($check > 0){
                    Yii::$app->session->setFlash('error', 'This level already exists');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $level = $this->findModel($id)->level;
        AmountGethelp::deleteAll('level = :level', [':level' => $level]);
        ProfitForsendhelp::deleteAll('level = :level', [':level' => $level]);
        CharityLevel::deleteAll('level = :level', [':level' => $level]);
        ReferralBonus::deleteAll('level = :level', [':level' => $level]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LevelSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LevelSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LevelSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

        public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($_POST['act'] == "close")
            $publish = LevelSetting::PUB_NOACTIVE;
        else
            $publish = LevelSetting::PUB_ACTIVE;

        $model = $this->findModel($_POST['id']);
        $model->publish = $publish;
        $model->updated_at = time();
        if($model->save()){
            return ['ok'];
        }
    }
}
