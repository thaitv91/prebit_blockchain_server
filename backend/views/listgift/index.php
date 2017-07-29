<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ListGift;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Gifts';
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
                        <?= Html::a('Create New Gift', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            [
                                'attribute' => 'color',
                                'label' => 'Color',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return '<div style="background-color: '.$data['color'].';color:#fff;padding: 5px 10px">'.$data['color'].'</div>';
                                }
                            ],
                            [
                                'attribute' => 'thumbnail',
                                'label' => 'Thumbnail',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return '<img height="50" src="'.Yii::$app->params['site_url_front_end'].'/uploads/luckywheel/'.$data['thumbnail'].'">';
                                }
                            ],
                            [
                                'attribute' => 'publish',
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['publish'] == ListGift::PUBLISH_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    } else {
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    return '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                                'contentOptions' => ['class' => 'text-right'],
                                'buttons' => [
                                    'update' => function ($url,$data) {
                                        return Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/listgift/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                        ]);
                                    },
                                    'delete' => function ($url,$data) {
                                        return Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/listgift/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>    
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["listgift/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>