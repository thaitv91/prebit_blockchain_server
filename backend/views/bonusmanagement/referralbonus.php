<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\GhTransfer;
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
                    <?= $form->field($bonushistoryfilter, 'username', ['template' => '{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control'])->label(false) ?>
                    <?= $form->field($bonushistoryfilter, 'fromday', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                    <?= $form->field($bonushistoryfilter, 'today', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
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
                            [
                            	'attribute' => '',
                            	'label' => 'Username',
                            	'format' => 'raw',
                            	'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                            	'value' => function($data){
                            		return $data->reciever->username;
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
                                'label' => 'Reciever of',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data){
                                    return $data->user->username;
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
                            
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                    ]); ?>
				</div><!-- /.span -->
			</div><!-- /.row -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
