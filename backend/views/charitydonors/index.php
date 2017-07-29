<?php
use common\models\CharityProgram;
use common\models\CharityDonors;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Charity Donnors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="charity-program-index">

        <h1><?= Html::encode($this->title) ?></h1>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],

                
                [
                    'label' => 'User Name',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->user->username;                 
                                               
                    },
                ],
                [
                    'label' => 'Email',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->user->email;                 
                                               
                    },
                ],
                [
                    'label' => 'Charity Program Title',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->program->title;
                                               
                    },
                ],
                [
                    'label' => 'Amount Donate',
                    'format' => 'html',
                    'value' => function ($data) {                        
                        return $data->sumamount.' '.'BTC';                                                    
                    },
                ],                                

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
