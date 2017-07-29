<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use common\models\Cashwithdraw;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cashwithdraws';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Tables
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Static &amp; Dynamic Tables
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                <?= $form->field($cashwithdrawFilter, 'username', ['template' => '{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control'])->label(false) ?>
                <?= $form->field($cashwithdrawFilter, 'status')->dropDownList($cashwithdrawFilter->listStatus, ['class'=>'form-control'])->label(false); ?>
                <?= $form->field($cashwithdrawFilter, 'fromday', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                <?= $form->field($cashwithdrawFilter, 'today', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                <?php ActiveForm::end(); ?>
                <h2></h2>
            </div>
            <div class="col-xs-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                    'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'User',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center hidden-480'],
                            'contentOptions' => ['class' => 'text-center hidden-480'],
                            'value' => function($data) {
                                return $data->getUser($data->user_id)->username;
                            }
                        ],
                        [
                            'label' => 'Currency',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center hidden-480'],
                            'contentOptions' => ['class' => 'text-center hidden-480'],
                            'value' => function($data) {
                                return $data->getCurrency($data->currency)->currency;
                            }
                        ],
                        [
                            'attribute' => 'bank_name',
                            'label' => 'Bank name',
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'Amount',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->amount.' BTC';
                            }
                        ],
                        [
                            'attribute' => 'fee',
                            'label' => 'Fee',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->fee.' '.$data->getCurrency($data->currency)->currency ;
                            }
                        ],
                        [
                            'attribute' => 'amount_convert',
                            'label' => 'Cash',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->amount_convert.' '.$data->getCurrency($data->currency)->currency ;
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Created at',
                            'format' => 'raw',
                            'value' => function($data) {
                                return date('H:s d/m/Y', $data->created_at);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'label' => 'Status',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function($data) {
                                if ($data['status'] == Cashwithdraw::STATUS_COMPLETED){
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
                            'template' => '<div class="hidden-sm hidden-xs btn-group">{view}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                            'contentOptions' => ['class' => 'text-right'],
                            'buttons' => [
                                'view' => function($url, $data){
                                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/cashwithdraw/view/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
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
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["cashwithdraw/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>
