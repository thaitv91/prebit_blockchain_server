<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use common\models\User;

$this->title = 'Message compose';
?>
<div class="page-heading">
	<h1><i class='fa fa-envelope'></i> E-mail</h1>
	            	</div>
<!-- Page Heading End-->				
<!-- Your awesome content goes here -->
<div class="box-info box-messages animated fadeInDown">
	<div class="row">
		<div class="col-md-3">
			<!-- Sidebar Message -->
			<div class="btn-group new-message-btns stacked">
				<?php echo Html::a('<i class="icon-left-open-1"></i> Back To Inbox', '/message/inbox/', ['class'=>'btn btn-primary btn-lg btn-block text-left']) ?>
			</div>
			<div class="list-group menu-message">
				<?php echo Html::a('<i class="icon-inbox"></i> Inbox', '/message/inbox/', ['class'=>'list-group-item']) ?>
				<?php echo Html::a('<i class="icon-export"></i> Sent', '/message/sent/', ['class'=>'list-group-item']) ?>
			</div>
		</div><!-- ENd div .col-md-2 -->
		<div class="col-md-9">
			<div class="no-margin widget">
				<div class="widget-content padding min-height500">
					<div class="mail-title">
						Compose Mail <i class="fa fa-pencil"></i>
					</div>
					<div style="clear: both"></div>
					<?php $form = ActiveForm::begin(['layout' => 'default', 'options' => [ 'enctype' => 'multipart/form-data']]) ?>

						<?= $form->field($compose, 'user_id', ['template' => '<label class="admin-left control-label no-padding-right" for="form-field-1">To:</label><div class="admin-right">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Admin','readonly' => true, 'class' => 'form-control'])->label(false) ?>
						<?= $form->field($compose, 'title', ['template' => '<label class="admin-left control-label no-padding-right" for="form-field-1">Subject:</label><div class="admin-right">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>

						<?= $form->field($compose, 'content')->widget(CKEditor::className(), [
					        'options' => ['rows' => 6],
					        'preset' => 'basic'
					    ]) ?>
						
						<?=$form->field($compose,'file')->fileInput(['type'=>'file','title'=>'<i class="fa fa-2x fa-folder-open" aria-hidden="true"></i> Attach File','class'=>'btn']); ?>
						<div class="row">
							<div class="col-xs-12">
								<?= Html::submitButton('<i class="icon-paper-plane-1"></i> Send', ['class'=> 'btn btn-success']) ;?>
							</div>
						</div>	
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End of your awesome content -->
