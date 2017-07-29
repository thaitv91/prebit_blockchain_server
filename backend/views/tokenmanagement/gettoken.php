<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TokenTransfer;
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

                    <?php if(Yii::$app->session->hasFlash('alert_gettoken')): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            <?= Yii::$app->session->getFlash('alert_gettoken') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php $form = ActiveForm::begin(['layout' => 'inline',]); ?>
                    <?= $form->field($gettoken, 'username', ['template' => '{input}{hint}{error}'])->textInput(['placeholder' => 'User name', 'class' => 'form-control', 'required' => 'required'])->label(false) ?>
                    <?= $form->field($gettoken, 'amount', ['template' => '{input}{hint}{error}'])->textInput(['type' => 'number', 'placeholder' => 'Amount', 'class' => 'form-control', 'required' => 'required'])->label(false) ?>

                    <?= Html::submitButton('<i class="ace-icon fa fa-paper-plane"></i><span class="bigger-110">Get fee!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                    <?php ActiveForm::end(); ?>
                    <h2></h2>
                </div>
			</div><!-- /.row -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
