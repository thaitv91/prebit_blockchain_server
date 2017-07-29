<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\States;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model common\models\states */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
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
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?php 
                    //echo '<pre>'; print_r($dataProvider); echo '</pre>'; exit;
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'attribute' => 'name',
                                'label' => 'State',
                            ],
                            [
                                'attribute' => 'city',
                                'label' => 'City',
                            ],
                            [
                                'attribute' => 'code',
                                'label' => 'Postcode/Citycode',
                            ],
                            [
                                'label' => 'Add city',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center hidden-480'],
                                'contentOptions' => ['class' => 'text-center hidden-480'],
                                'value' => function($data) {
                                    if ($data['create_city'] == 1)
                                        $link = Html::a('<span class="fa fa-plus-square fa-lg"></span>', ['cities/create', 'id' => $data['id']]);
                                    else
                                        $link = '';
                                    return $link;
                                }
                            ],
                            [
                                'attribute' => 'publish',
                                'label' => 'Publish',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['publish'] == States::PUBLISH_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    }else{
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    if($data['city'] != '-'){
                                        $type = 'city';
                                    }else{
                                        $type = 'state';
                                    }
                                    return '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" '.$check.' type="checkbox" data="'.$type.'" act="'.$act.'" value="'.$data['id'].'" /><span class="lbl"></span>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '<div class="hidden-sm hidden-xs btn-group">{update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{update}</li<li>{delete}</li<ul><div></div> ',
                                'contentOptions' => ['class' => 'text-right'],
                                'buttons' => [
                                    'update' => function ($url,$data) {
                                        return $data['city'] != '-' ?
                                        Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/cities/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                        ]) : Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/states/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                        ]);
                                    },
                                    'delete' => function ($url,$data) {
                                        return $data['city'] != '-' ?
                                        Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/cities/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                                        ]) : Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/states/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-danger'
                                        ]);
                                    },
                                ],
                            ],
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                    ]) ?>
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
        url:"' . Yii::$app->urlManager->createUrl(["states/publish"]) . '", 
        data: {id:id,type:type,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>