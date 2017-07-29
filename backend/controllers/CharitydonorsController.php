<?php

namespace backend\controllers;

use Yii;
use common\models\CharityProgram;
use common\models\CharityDonors;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CharityProgramController implements the CRUD actions for CharityProgram model.
 */
class CharitydonorsController extends Controller
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
     * Lists all CharityProgram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $list_donate = 'SELECT id, amount, user_id, charity_program_id,  SUM(amount) AS sumamount  FROM charity_donors GROUP BY user_id';
        $query = CharityDonors::findBySql($list_donate);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CharityProgram model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
