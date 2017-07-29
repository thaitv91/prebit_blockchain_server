<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\Countries;
use common\models\States;
use common\models\Cities;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
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

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($userfilter, 'username', ['template' => '<label>Username : </label>{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control']) ?>
                            <?= $form->field($userfilter, 'fullname', ['template' => '<label>Fullname : </label>{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'Full name', 'class' => 'form-control']) ?>
                            <?= $form->field($userfilter, 'phone', ['template' => '<label>Phone : </label>{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'Phone', 'class' => 'form-control']) ?>
                            <?= $form->field($userfilter, 'email', ['template' => '<label>Email : </label>{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'Email', 'class' => 'form-control']) ?>
                            <?= $form->field($userfilter, 'dayfrom', ['template' => '<label>From : </label><div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                            <?= $form->field($userfilter, 'dayto', ['template' => '<label>To : </label><div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                        </div>
                    </div>   
                    <h3></h3>
                    <div class="row"> 
                        <div class="col-md-12">
                            <?= $form->field($userfilter, 'status', ['template' => '<label>Status : </label>{input}{hint}{error}'])->dropDownList($userfilter->listStatus, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'publish', ['template' => '<label>Publish : </label>{input}{hint}{error}'])->dropDownList($userfilter->listPublish, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'level', ['template' => '<label>Level : </label>{input}{hint}{error}'])->dropDownList($userfilter->listLevel, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'shstatus', ['template' => '<label>Deposit status : </label>{input}{hint}{error}'])->dropDownList($userfilter->listShstatus, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'downline', ['template' => '<label>Sort by : </label>{input}{hint}{error}'])->dropDownList($userfilter->listDownline, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'country', ['template' => '<label>Country : </label>{input}{hint}{error}'])->dropDownList($userfilter->listCountry, ['class'=>'form-control'])->label(false); ?>
                            <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                        </div>
                    </div>    
                    <?php ActiveForm::end(); ?>
                    <h2></h2>
                </div>
 
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div>Total - Main Wallet: <?php echo number_format($total_wallet, 8); ?> BTC</div>
                    <div>Total - Bonus Wallet: <?php echo number_format($total_bonus, 8); ?> BTC</div>
                </div>

                <div class="col-xs-12">
                    <!-- <p>
                        <?//= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
                    </p> -->
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'pager' => [
                            'firstPageLabel' => 'First',
                            'lastPageLabel'  => 'Last'
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                                'headerOptions' => ['class' => 'text-center hidden-480'],
                                'contentOptions' => ['class' => 'text-center hidden-480'],
                            ],
                            [
                                'attribute' => 'username',
                                'label' => 'User name',
                            ],
                            [
                                'attribute' => 'fullname',
                                'label' => 'Full name',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                            ],
                            [
                                'attribute' => 'email',
                                'label' => 'Email',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                            ],
                            [
                                'attribute' => 'wallet',
                                'label' => 'Main wallet',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return number_format($data['wallet'], 8); 
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Bonus wallet',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return number_format( $data['manager_bonus'] + $data['referral_bonus'] , 8); 
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Deposit amount',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                                'value' => function($data) {
                                    if(!empty($data->getTotalSh($data['id']))){
                                        return number_format($data->getTotalSh($data['id']), 8);
                                    }else{
                                        return 0;
                                    }
                                    
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['status'] == User::STATUS_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    } else {
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    return '<input name="status" class="ace ace-switch ace-switch-4 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                                }
                            ],
                            [
                                'attribute' => 'block',
                                'label' => 'Block',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['block'] == User::BLOCK_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    } else {
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    return '<input name="block" class="ace ace-switch ace-switch-6 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                                }
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '<div class="hidden-sm hidden-xs btn-group">{view}</div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li>{view}</li<li>{update}</li<li>{delete}</li<ul><div></div> ',
                                'contentOptions' => ['class' => 'text-right'],
                                'buttons' => [
                                    'view' => function($url, $data){
                                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/user/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
                                        ]);
                                    },
                                    // 'update' => function ($url,$data) {
                                    //     return Html::a('<i class="ace-icon fa fa-pencil bigger-120"></i>', '/user/update/'.$data['id'], ['title' => Yii::t('app', 'Update'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-info'
                                    //     ]);
                                    // },
                                    // 'delete' => function ($url,$data) {
                                    //     return Html::a('<i class="ace-icon fa fa-trash-o bigger-120"></i>', '/user/delete/'.$data['id'],['title' => Yii::t('app', 'Delete'),'data-pjax' => '0','data-method'=>'post','data-confirm'=>'Are you sure you want to delete this item?','class'=>'btn btn-xs btn-warning'
                                    //     ]);
                                    //},
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
$("input[name=status]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["user/status"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>

<?= $this->registerJs('
$("input[name=block]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["user/block"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>


