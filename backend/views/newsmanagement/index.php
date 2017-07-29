<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Newsmanagement;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'description',
                'label' => 'Description',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-left'],
                'contentOptions' => ['class' => 'text-left'],
                'value' => function($data) {                    
                    if (strlen($data->description) <= 50)
                        return $data->description;
                    else
                        return substr($data->description, 0, 50) . '...';
                }
            ],
            
            [
                'attribute' => 'publish',
                'label' => 'Publish',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($data) {
                    if ($data['publish'] == Newsmanagement::PUBLISH_ACTIVE){
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
                'template' => '<div class="hidden-sm hidden-xs btn-group"> {update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                'contentOptions' => ['class' => 'text-right'],
                'buttons' => [
                    'view' => function($url, $data){
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/newsmanagement/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
                        ]);
                    },
                    'update' => function ($url,$data) {
                        return Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/newsmanagement/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                        ]);
                    },
                    'delete' => function ($url,$data) {
                        return Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/newsmanagement/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["newsmanagement/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>