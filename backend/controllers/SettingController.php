<?php

namespace backend\controllers;

use Yii;
use common\models\Setting;
use common\models\Converted;
use common\models\LevelSetting;
use common\models\CharityLevel;
use common\models\AmountGethelp;
use common\models\TokenForgethelp;
use common\models\TokenForsendhelp;
use common\models\ShPacket;
use common\models\ProfitForsendhelp;

use common\models\ReferralBonus;
use common\models\ManagerBonus;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends BackendController
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
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Setting::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Setting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Setting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionGeneral(){
        $bitpertoken = $model = Converted::find()->where(['object'=>'token'])->one();
        $usdperticket = $model = Converted::find()->where(['object'=>'ticket'])->one();
        $tokenregister = Converted::find()->where(['object'=>'tokenregister'])->one();
        $standbytimegh = Converted::find()->where(['object'=>'standbytimegh'])->one();
        $standbyforblock = Converted::find()->where(['object'=>'standbyforblock'])->one();
        $fineamount = Converted::find()->where(['object'=>'fineamount'])->one();
        $level = LevelSetting::find()->orderBy(['level' => SORT_ASC])->all();
        $amountgethelp = AmountGethelp::find()->orderBy(['level' => SORT_ASC])->all();
        $charitysetting = CharityLevel::find()->orderBy(['level' => SORT_ASC])->all();
        $tokenforgh = TokenForgethelp::find()->orderBy(['token' => SORT_ASC])->all();
        $tokenforsh = TokenForsendhelp::find()->orderBy(['token' => SORT_ASC])->all();
        $shpacket = ShPacket::find()->orderBy(['min_days' => SORT_ASC])->all();
        $profitforsh = ProfitForsendhelp::find()->orderBy(['packet_sh' => SORT_ASC])->all();


        

        $referral = ReferralBonus::find()->orderBy(['level' => SORT_ASC])->all();
        $manager = ManagerBonus::find()->orderBy(['floor' => SORT_ASC])->all();
        
        return $this->render('general', [
            'bitpertoken' => $bitpertoken->value,
            'usdperticket' => $usdperticket,
            'level' => $level,
            'amountgethelp' => $amountgethelp,
            'charitysetting' => $charitysetting,
            'tokenforgh' => $tokenforgh,
            'tokenforsh' => $tokenforsh,
            'shpacket' => $shpacket,
            'profitforsh' => $profitforsh,
            'tokenregister' => $tokenregister,
            'referral' => $referral,
            'manager' => $manager,
            'standbytimegh' => $standbytimegh,
            'standbyforblock' => $standbyforblock,
            'fineamount' => $fineamount,
        ]);
    }

    public function actionUpdatebtcpertoken(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'token'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdateusdperticket(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'ticket'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    

    public function actionUpdatetokenregister(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'tokenregister'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdatestandbytime(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'standbytimegh'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdatestandbyforblock(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'standbyforblock'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdatefineamount(){
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Converted::find()->where(['object'=>'fineamount'])->one();
        $model->value = $_POST['value'];
        if($model->save()){
            return ['ok'];
        }
    }

    public function actionUpdatecharitysetting(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $charity = CharityLevel::find()->where(['level'=>$value['id']])->one();
            $charity->amount = $value['amount'];
            $charity->save();
        }
    }

    public function actionUpdateamountgethelp(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $amountgethelp = AmountGethelp::find()->where(['level'=>$value['id']])->one();
            $amountgethelp->amountsh = $value['sh'];
            $amountgethelp->amountgh = $value['gh'];
            $amountgethelp->save();
        }
    }

    public function actionUpdatetokenforgh(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $tokenForgethelp = TokenForgethelp::find()->where(['token'=>$value['id']])->one();
            $tokenForgethelp->min_mainw = $value['min_mainw'];
            $tokenForgethelp->max_mainw = $value['max_mainw'];
            $tokenForgethelp->min_bonusw = $value['min_bonusw'];
            $tokenForgethelp->max_bonusw = $value['max_bonusw'];
            $tokenForgethelp->save();
        }
    }

    public function actionUpdatetokenforsh(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $tokenForsendhelp = TokenForsendhelp::find()->where(['token'=>$value['id']])->one();
            $tokenForsendhelp->min_amount = $value['min_amount'];
            $tokenForsendhelp->max_amount = $value['max_amount'];
            $tokenForsendhelp->created_at = time();
            $tokenForsendhelp->save();
        }
    }

    public function actionUpdatesendhelppacket(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $shpacket = ShPacket::findOne($value['id']);
            $shpacket->min_days = $value['minday'];
            $shpacket->max_days = $value['maxday'];
            $shpacket->min_amount = $value['minamount'];
            $shpacket->max_amount = $value['maxamount'];
            $shpacket->created_at = time();
            $shpacket->save();
        }
    }


    public function actionUpdateprofitforsendhelp(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $profitforsh = ProfitForsendhelp::find()->where(['packet_sh'=>$value['id']])->one();
            $profitforsh->staged1 = $value['staged1'];
            $profitforsh->staged2 = $value['staged2'];
            $profitforsh->staged3 = $value['staged3'];
            $profitforsh->staged4 = $value['staged4'];
            $profitforsh->staged5 = $value['staged5'];
            $profitforsh->staged6 = $value['staged6'];
            $profitforsh->staged7 = $value['staged7'];
            var_dump($profitforsh->save());
        }
    }


    public function actionUpdatereferral(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $charity = ReferralBonus::find()->where(['level'=>$value['id']])->one();
            $charity->profit = $value['amount'];
            if($charity->save()){
                var_dump('ok');
            }
        }
    }


    public function actionUpdatemanager(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arr = $_POST['arr'];
        foreach ($arr as $key => $value) {
            $charity = ManagerBonus::find()->where(['floor'=>$value['id']])->one();
            $charity->profit = $value['amount'];
            $charity->save();
        }
    }


}
