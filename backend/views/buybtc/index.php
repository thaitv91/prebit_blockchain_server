<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buy Btcs';
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
                    <?= Html::a('Create Buy Btc', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'country_id',
                        'address',
                        [
                            'class' => 'yii\grid\ActionColumn', 
                            'template' => '<div class="hidden-sm hidden-xs btn-group">{update} {delete}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                            'contentOptions' => ['class' => 'text-right'],
                            'buttons' => [
                                'update' => function ($url,$data) {
                                    return $data['country_id'] != '' ?
                                    '' : Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/buybtc/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                    ]);
                                },
                                'delete' => function ($url,$data) {
                                    return $data['country_id'] != '' ?
                                    '' : Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/buybtc/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-danger'
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
