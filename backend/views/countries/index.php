<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Countries;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Countries';
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
                        <?= Html::a('Create Countries', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                                'headerOptions' => ['class' => 'text-center hidden-480'],
                                'contentOptions' => ['class' => 'text-center hidden-480'],
                            ],
                            [
                                'attribute' => 'name',
                                'label' => 'Country',
                            ],
                            [
                                'attribute' => 'country_code',
                                'label' => 'Country code',
                                'headerOptions' => ['class' => 'text-center hidden-480'],
                                'contentOptions' => ['class' => 'text-center hidden-480'],
                            ],
                            [
                                'attribute' => 'state',
                                'label' => 'State',
                            ],
                            [
                                'attribute' => 'postcode',
                                'label' => 'Post code',
                                'headerOptions' => ['class' => 'text-center hidden-480'],
                                'contentOptions' => ['class' => 'text-center hidden-480'],
                            ],
                            // [
                            //     'label' => 'Add state',
                            //     'format' => 'raw',
                            //     'headerOptions' => ['class' => 'text-center hidden-480'],
                            //     'contentOptions' => ['class' => 'text-center hidden-480'],
                            //     'value' => function($data) {
                            //         if ($data['create_state'] == 1)
                            //             $link = Html::a('<span class="fa fa-plus-square fa-lg"></span>', ['states/create', 'id' => $data['id']]);
                            //         else
                            //             $link = '';
                            //         return $link;
                            //     }
                            // ],
                            [
                                'attribute' => 'publish',
                                'label' => 'Publish',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['publish'] == Countries::PUBLISH_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    }else{
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    if($data['state'] != '-'){
                                        $type = 'state';
                                    }else{
                                        $type = 'country';
                                    }
                                    return '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" '.$check.' type="checkbox" data="'.$type.'" act="'.$act.'" value="'.$data['id'].'" /><span class="lbl"></span>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '<div class="hidden-sm hidden-xs btn-group">{view} {update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                                'contentOptions' => ['class' => 'text-right'],
                                'buttons' => [
                                    'view' => function($url, $data){
                                        return $data['state'] != '-' ?
                                        Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/states/view/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
                                        ]) : '';
                                    },
                                    'update' => function ($url,$data) {
                                        return $data['state'] != '-' ?
                                        Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/states/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                        ]) : Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/countries/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                        ]);
                                    },
                                    'delete' => function ($url,$data) {
                                        return $data['state'] != '-' ?
                                        Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/states/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                                        ]) : Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/countries/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-danger'
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

<?=$this->registerJs("
jQuery(function($) {
    var active_class = 'active';
    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        });
    });
})
");?>

<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var type = $(this).attr("data");
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["countries/publish"]) . '", 
        data: {id:id,type:type,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>