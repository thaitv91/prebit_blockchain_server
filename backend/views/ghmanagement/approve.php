<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\GhTransfer;
$pending_count =  GhTransfer::find()->where(['publish' => GhTransfer::PUBLISH_NOACTIVE])->sum('amount');
?>
<div class="page-content">
	<div class="page-header">
		<h1>
			Approve Action
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Approve Pending GH
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
               
				<div class="col-md-12 col-sm-12 col-xs-12">
                    <?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
                        <?= Html::submitButton('<i class="ace-icon fa fa-paper-plane bigger-110"></i> Approve', ['class' => 'btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
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