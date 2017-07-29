<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\MemberController;
use common\models\User;
use common\models\Notify;
use yii\web\UploadedFile;
use dosamigos\ckeditor\CKEditor;

$this->title = 'Message';
?>
<!-- Page Heading Start -->
<div class="page-heading">
	<h1><i class='fa fa-envelope'></i> E-mail</h1>
</div>
<!-- Page Heading End-->
<!-- Begin Inbox -->
<div class="box-messages">
	<div class="row">
		<div class="col-md-3">
		<!-- Sidebar Message -->
		<div class="btn-group new-message-btns stacked">
			<?php echo Html::a('Compose', '/message/compose/', ['class'=>'btn btn-success btn-lg col-xs-12']) ?>							
		</div>
		<div class="list-group menu-message">
			<?php echo Html::a('<i class="icon-inbox"></i> Inbox', '/message/inbox/', ['class'=>'list-group-item']) ?>
			<?php echo Html::a('<i class="icon-export"></i> Sent', '/message/sent/', ['class'=>'list-group-item active']) ?>
		</div>
	</div><!-- ENd div .col-md-2 -->						
		<div class="col-md-9">
			<div class="widget">
				<div class="col-sm-12">
					<!-- Begin read message -->
					<!-- Message -->
					<div class="row">
						<div class="col-sm-8">
							<h3 class="semibold"><?=$model->title;?></h3>
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="mail-sender-details">
								<?php echo '<img src="/images/icon-avarta.png" alt="img" class="img img-circle sender-photo">'; ?>
								<small><b>Admin</b><br><span class="text-muted"><?php echo date('m/d/y H:i A', $model->created_at); ?></span></small>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-12 mail-body">
							<div class="conv">
								<hr>
								<?php foreach ($ms as $key => $value): ?>
									<div class="ms-all ms-key-<?php if($value->user_id == Notify::ADMIN_ID){echo "admin ";}else{echo "member";} ?>">
										<?php if ($value->user_id == Notify::ADMIN_ID): ?>
											<div class="boc-ms">
												<?php echo '<img src="/images/icon-avarta.png" alt="img" class="img">'; ?>
												<p class="info-admin">Admin<br>
													<span class="date-posts"><?php echo date('m/d/y H:i A', $value->created_at); ?></span>
												</p>
											</div>
										<?php else: ?>
											<div class="boc-ms">
												<?php if ($value->user_id != 0) {
													if (!empty($value->findAvatar($value->id)->avatar)) {
														echo '<img src="'.Yii::$app->params['site_url'].'uploads/users/'.$value->findAvatar($value->id)->avatar.'" alt="img" class="img">';
													}else{
														echo '<img class ="img" src="'.Yii::$app->params['site_url'].'uploads/users/default-avatar.jpg">';
													}																	
													echo '<p class="info-mem">';
													echo $value->findAvatar($value->id)->username;
													echo '<br>';
													echo '<span class="date-posts">';
													echo date('m/d/y H:i A', $value->created_at);
													echo '</span>';
													echo '</p>';
												} 
												?>
											</div>																
										<?php endif ?>
										<p class="<?php if($value->user_id == Notify::ADMIN_ID){echo "ballon color1";}else{echo "ballon color2";} ?>">
											<?=$value->content; ?><br>
											<?php if ($value->user_id != 0 && $value->attach_file != NULL) {
												echo '<p class="addition"><i class="fa fa-file-o"></i>';
												echo substr($value->attach_file, 16).' - ';
												echo '<a target="_blank" href="';
												echo  Yii::$app->params['site_url'].$value->attach_file;
												echo '">Download</a></p>';
											}
											elseif($value->user_id == Notify::ADMIN_ID && $value->attach_file != NULL){
												echo '<p class="addition"><i class="fa fa-file-o"></i>';
												echo substr($value->attach_file, 16).' - ';
												echo '<a target="_blank" href="';
												echo  Yii::$app->params['site_url'].$value->attach_file;
												echo '">Download</a></p>';
											} 
											?>	
										</p>
									</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if (Yii::$app->session->hasFlash('success')) { ?>
	            <div class="alert alert-success" role="alert">
	                <?= Yii::$app->session->getFlash('success') ?>
	            </div>
	        <?php } ?>
			<?php $form = ActiveForm::begin(['options' => [ 'enctype' => 'multipart/form-data', 'id'=> 'repply-for']]) ?>
			<div class="widget lightblue-2">
				<div class="widget-header transparent">
					<h2>Reply Mail</h2>
					<div class="additional-btn">
						<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					</div>
				</div>
				<div class="widget-content padding">
					<?= $form->field($repply, 'content')->widget(CKEditor::className(), [
					        'options' => ['rows' => 6],
					        'preset' => 'basic'
					    ]) ?>
				</div>
			</div>
			<div class="pull-right">
				<?=$form->field($model,'file')->fileInput(['type'=>'file','title'=>'<i class="fa fa-2x fa-folder-open" aria-hidden="true"></i>','class'=>'btn']); ?>
			</div>
			<?= Html::submitButton('Reply', ['class'=> 'btn btn-success']) ;?>
			 <?php ActiveForm::end(); ?>
		</div><!-- End div .col-md-10 -->
	</div><!-- End div .row -->
</div><!-- End div .box-info -->
<!-- End inbox -->