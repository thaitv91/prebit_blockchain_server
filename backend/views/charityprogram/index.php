<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CharityProgram;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Charity Programs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="charity-program-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Charity Program', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title',
                // 'content:ntext',
                'startday:datetime',
                [
                    'label' => 'Endday',
                    'format' => 'html',
                    'value' => function ($data) {
                       return date('d M Y',$data->endday);                
                                               
                    },
                ],
                [
                    'label' => 'Amount',
                    'format' => 'html',
                    'value' => function ($data) {
                        if (!empty($data->getdonate($data->id))) {
                            return $data->getdonate($data->id).' '.'BTC'; 
                        }
                        else{
                            return '0 BTC'; 
                        }                  
                                               
                    },
                ],
                // 'note:ntext',
                [
                    'label' => 'Status',
                    'format' => 'html',
                    'value' => function ($data) {
                        $today = strtotime(date('Y-m-d'));
                        
                        if ($data->endday >= $today) {
                            return 'Running';
                        }
                        elseif($data->endday < $today){
                            return 'Completed';
                        }                
                               
                    },
                ],
                [
                    'attribute' => 'publish',
                    'label' => 'Publish',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function($data) {
                        if ($data['publish'] == CharityProgram::PUBLISH_ACTIVE){
                            $check = 'checked';
                            $act = 'close';
                        } else {
                            $check = '';
                            $act = 'opent';
                        }
                        return '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                    }
                ],
                // 'created_at:datetime',
                // 'updated_at:datetime',

                [
                    'class' => 'yii\grid\ActionColumn', 
                    'template' => '<div class="hidden-sm hidden-xs btn-group"> {update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                    'contentOptions' => ['class' => 'text-right'],
                    'buttons' => [
                        'view' => function($url, $data){
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/charityprogram/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
                            ]);
                        },
                        'update' => function ($url,$data) {
                            return Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/charityprogram/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                            ]);
                        },
                        'delete' => function ($url,$data) {
                            return Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/charityprogram/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["charityprogram/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>