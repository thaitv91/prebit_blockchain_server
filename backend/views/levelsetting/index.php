<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Levelsetting;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Level Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                <p>
                    <?= Html::a('Create Level Setting', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                    'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                    'columns' => [
                        'level',
                        'amount',
                        'child',
                        'child_level',
                        'child_2',
                        'child_level_2',
                        'token',
                        'ticket',
                        'manager_bonus',
                        'amount_sh',
                        [
                            'attribute' => 'publish',
                            'label' => 'Publish',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function($data) {
                                if ($data['publish'] == Levelsetting::PUB_ACTIVE){
                                    $check = 'checked';
                                    $act = 'close';
                                }else{
                                    $check = '';
                                    $act = 'opent';
                                }
                                return '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" '.$check.' type="checkbox" act="'.$act.'" value="'.$data['id'].'" /><span class="lbl"></span>';
                            }
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '<div class="hidden-sm hidden-xs btn-group">{update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{update}</li<li>{delete}</li<ul><div></div> ',
                            'contentOptions' => ['class' => 'text-right'],
                            'buttons' => [
                                'update' => function ($url,$data) {
                                    return Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/levelsetting/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                    ]);
                                },
                                'delete' => function ($url,$data) {
                                    return Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/levelsetting/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                                    ]);
                                },
                            ],
                        ],
                    ],
                    'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                ]); ?>
                </div><!-- /.span -->
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var type = $(this).attr("data");
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["levelsetting/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>
