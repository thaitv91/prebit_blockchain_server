<?php
use yii\helpers\Html;
use common\models\User;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\GhTransfer;
use common\extensions\jsonRPCClient;
use common\extensions\Client;

$pending_count =  GhTransfer::find()->where(['publish' => GhTransfer::PUBLISH_NOACTIVE])->sum('amount');

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
                    <?php if(Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <?= Yii::$app->session->getFlash('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                    <?= $form->field($ghtransferfilter, 'username', ['template' => '{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control'])->label(false) ?>
                    <?= $form->field($ghtransferfilter, 'status')->dropDownList($ghtransferfilter->listStatus, ['class'=>'form-control'])->label(false); ?>
                    <?= $form->field($ghtransferfilter, 'fromday', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                    <?= $form->field($ghtransferfilter, 'today', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                    <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                    <div>Pending Amount: <strong> <?=$pending_count; ?></strong> BTC</div>
                    <?php ActiveForm::end(); ?>
                    <h2></h2>
                </div>
                
				<div class="col-xs-12">
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
                                 	if($data->publish == GhTransfer::PUBLISH_NOACTIVE){
									 	$status = '<span class="label label-sm label-success">Pending</span>';
									} 
                                    if($data->publish == GhTransfer::PUBLISH_ACTIVE){
										$status = '<span class="label label-sm label-danger">Completed</span>';
									}
                                	return $status;
                                    
                                }
                            ],

                            [
                                'attribute' => '',
                                'label' => 'Approve',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    // var_dump($data);
                                    $user = User::findOne($data->user_id);
                                    $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
                                    $address_btc = $client->getAddressList($user->username);
                                    // $status = '<a href="/ghmanagement/approve?bitid=123456&amount='. $data->amount . '">Approve</a>';
                                    $status = '';
                                    if($data->publish != GhTransfer::PUBLISH_ACTIVE){
                                        $status = '<a onclick="return confirm(\'Are you sure you want to Approve?\')" href="/ghmanagement/approve?id='. $data->id .'&bitid='. $address_btc[0] .'&amount='. $data->amount . '">Approve</a>';
                                    }
                                    
                                    return $status;
                                }
                            ],
                            
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                    ]); ?>
				</div><!-- /.span -->
                <a href=""></a>
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