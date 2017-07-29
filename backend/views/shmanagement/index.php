<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ShTransfer;
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
                    <?= $form->field($shtransferfilter, 'username', ['template' => '{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control'])->label(false) ?>
                    <?= $form->field($shtransferfilter, 'status')->dropDownList($shtransferfilter->listStatus, ['class'=>'form-control'])->label(false); ?>
                    <?= $form->field($shtransferfilter, 'fromday', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                    <?= $form->field($shtransferfilter, 'today', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                    <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                    <?php ActiveForm::end(); ?>
                    <h2></h2>
                </div>

				<div class="col-xs-12">
                    <!-- alert div -->
                    <?php if(Yii::$app->session->hasFlash('success_shmanager')){ ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            <?= Yii::$app->session->getFlash('success_shmanager') ?>
                        </div>
                    <?php } ?>


					<!-- End top navigation -->
					<?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                            	'attribute' => '',
                            	'label' => 'Username',
                            	'format' => 'raw',
                            	'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                            	'value' => function($data){
                            		return $data->user->username;
                            	}
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Amount',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data){
                            		return $data->amount.' Btc';
                            	}
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Running days',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                                'value' => function($data) {
                                    if( ($data->publish == ShTransfer::PUBLISH_NOACTIVE) ||  ($data->status == ShTransfer::STATUS_COMPLETED) ){
                                        $datediff = $data->inc_days - $data->created_at;
                                        return floor($datediff/(60*60*24)).' Days';
                                    } else {
                                        $datediff = time() - $data->created_at;
                                        return floor($datediff/(60*60*24)).' Days';
                                    }
                                	
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Created at',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                                'value' => function($data) {
                                	return date('H:i d/m/Y', $data->created_at);
                                }
                            ],
                            [
                            	'attribute' => '',
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    if($data->publish == ShTransfer::PUBLISH_NOACTIVE){
                                        $status = '<span class="label label-sm label-danger">Canceled</span>';
                                    }
                                    if($data->publish == ShTransfer::PUBLISH_ACTIVE){
                                    	if($data->status == ShTransfer::STATUS_HOLD){
    										$status = '<span class="label label-sm label-success">On-going</span>';
    									} 
                                        if($data->status == ShTransfer::STATUS_WITHDRAW){
                                            $status = '<span class="label label-sm label-success">On-going</span>';
                                        } 
    									if($data->status == ShTransfer::STATUS_CAPITAL_WITHDRAW){
    										$status = '<span class="label label-sm label-warning">Maturity</span>';
    									} 
    									if($data->status == ShTransfer::STATUS_COMPLETED){
    										$status = '<span class="label label-sm label-info">Completed</span>';
    									}
                                    }    
                                	return $status;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '{view}',
                                'contentOptions' => ['class' => 'text-center'],
                                'buttons' => [
                                    'view' => function($url, $data){
                                        if($data->publish == ShTransfer::PUBLISH_ACTIVE){
                                            if($data->status < ShTransfer::STATUS_COMPLETED){
                                            
                                            return Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Cancel', '/shmanagement/cancel/'.$data['id'], ['title' => Yii::t('app', 'Cancel'),'data-pjax' => '0', 'data-confirm'=>'Do you want cancel this SHtransfer?', 'class'=>'btn btn-xs btn-danger'
                                            ]);
                                            }
                                        }
                                        
                                    },
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn', 
                                'template' => '{view}',
                                'contentOptions' => ['class' => 'text-center'],
                                'buttons' => [
                                    'view' => function($url, $data){
                                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', '/shmanagement/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>'btn btn-xs btn-success'
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