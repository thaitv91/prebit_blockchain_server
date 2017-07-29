<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\Notify;
use dosamigos\ckeditor\CKEditor;
?>

<div class="page-content">

	<div class="page-header">
		<h1>
			Notification
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Send notification for all users
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="message-list-container clearfix">
				<?php if (Yii::$app->session->getFlash('success')): ?>
						<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('success');?></div>
				<?php endif ?>					
				<?php $form = ActiveForm::begin(['options' => [ 'enctype' => 'multipart/form-data'], 'layout' => 'horizontal']); ?>
					<div>
						<?= $form->field($model, 'content',['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><span class="inline space-24 hidden-480"></span>Message: </label><div class="col-sm-6">{input}{hint}{error}</div>'])->widget(CKEditor::className(), [
					        'options' => ['rows' => 6],
					        'preset' => 'basic'
					    ]) ?>

						<div class="hr hr-18 dotted"></div>
						<div class="space"></div>
					</div>
					<div class="message-footer text-center clearfix">
						<?= Html::submitButton('Send', ['class'=> 'btn btn-sm btn-primary no-border btn-white btn-round']) ;?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>	
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->



<?=$this->registerJs("
jQuery(function($){
	//intialize wysiwyg editor
	$('.wysiwyg-editor').ace_wysiwyg({
		toolbar:
		[
			'bold',
			'italic',
			'strikethrough',
			'underline',
			null,
			'justifyleft',
			'justifycenter',
			'justifyright',
			null,
			'createLink',
			'unlink',
			null,
			'undo',
			'redo'
		]
	}).prev().addClass('wysiwyg-style1');



	//file input
	$('.message-form input[type=file]').ace_file_input()
	.closest('.ace-file-input')
	.addClass('width-90 inline')
	.wrap('<div class=\"form-group file-input-container\"><div class=\"col-sm-7\"></div></div>');

	//Add Attachment
	//the button to add a new file input
	$('#id-add-attachment')
	.on('click', function(){
		var file = $('<input type=\"file\" name=\"attachment[]\" />').appendTo('#form-attachments');
		file.ace_file_input();
		
		file.closest('.ace-file-input')
		.addClass('width-90 inline')
		.wrap('<div class=\"form-group file-input-container\"><div class=\"col-sm-7\"></div></div>')
		.parent().append('<div class=\"action-buttons pull-right col-xs-1\">\
			<a href=\"#\" data-action=\"delete\" class=\"middle\">\
				<i class=\"ace-icon fa fa-trash-o red bigger-130 middle\"></i>\
			</a>\
		</div>')
		.find('a[data-action=delete]').on('click', function(e){
			//the button that removes the newly inserted file input
			e.preventDefault();
			$(this).closest('.file-input-container').hide(300, function(){ $(this).remove() });
		});
	});
});

if(!ace.vars['touch']) {
	$('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize

	$(window)
	.off('resize.chosen')
	.on('resize.chosen', function() {
		$('.chosen-select').each(function() {
			 
			 $(this).next().css({'width': $(this).parent().width()});
		})
	}).trigger('resize.chosen');
	//resize chosen on sidebar collapse/expand
	$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
		if(event_name != 'sidebar_collapsed') return;
		$('.chosen-select').each(function() {
			
			 $(this).next().css({'width': $(this).parent().width()});
		})
	});


	$('#chosen-multiple-style .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
		 else $('#form-field-select-4').removeClass('tag-input-style');
	});
}
");?>					
