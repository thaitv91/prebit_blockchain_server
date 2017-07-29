<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\MemberController;
use common\models\User;
use common\models\Notify;
use common\models\Message;
use dosamigos\ckeditor\CKEditor;
?>
<div class="page-content">
	<div class="page-header">
		<h1>
			Sent
		</h1>
	</div><!-- /.page-header -->
	<div class="row page-view-chat">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<div class="tab-content no-border no-padding">
							<div id="inbox" class="tab-pane in active">
								<div class="message-container">
									<div id="id-message-list-navbar" class="message-navbar clearfix">
										<div class="message-bar">
											<div class="message-infobar" id="id-message-infobar">
											
											</div>
										</div>										
										<div class="messagebar-item-left">
											<?php echo Html::a('<i class="ace-icon fa fa-arrow-left blue bigger-110 middle"></i> <b class="bigger-110 middle">Back</b>', '/message/sent/', ['class'=>'btn-back-message-list']
			                                ) ?>			                                
										</div>											
									</div>
									<div class="message-list-container chat">
										<div class="message-content" id="id-message-content">
											<div class="message-header clearfix">
												<span class="blue bigger-125"> <?=$model->title; ?> </span> &nbsp; &nbsp;
												<i class="ace-icon fa fa-clock-o bigger-110 orange middle"></i>
												<span class="time grey"><?php echo date('m-d-Y H:i:s A', $model->created_at) ?></span>
												<div class="hr hr-18 dotted"></div>
												<ul class="conv">
										            <li>
														<?php foreach ($ms as $key => $value): ?>
															<div class="ms-all ms-key-<?php if($value->user_id == Notify::ADMIN_ID){echo "admin ";}else{echo "member";} ?>">

																<?php if ($value->user_id == Notify::ADMIN_ID): ?>
																	<div class="boc-ms">
																		<?php echo '<img src="/images/avatars/avatar.png" alt="img" class="img">'; ?>
																		<p class="info-admin">Admin</p>
																	</div>
																<?php else: ?>
																	<div class="boc-ms">
																		<?php if ($value->user_id != 0) {
																			if (!empty($value->findAvatar($value->id)->avatar)) {
																				echo '<img src="'.Yii::$app->params['site_url_front_end'].'uploads/users/'.$value->findAvatar($value->id)->avatar.'" alt="img" class="img">';
																			}else{
																				echo '<img src="'.Yii::$app->params['site_url_front_end'].'uploads/users/default-avatar.jpg'.'" alt="img" class="img">';
																			}																			
																			echo '<p class="info-mem">';
																			echo $value->findAvatar($value->id)->username;
																			echo '</p>';
																		} ?>
																	</div>																
																<?php endif ?>
																<p class="<?php if($value->user_id == Notify::ADMIN_ID){echo "ballon color1";}else{echo "ballon color2";} ?>">
																	<?=$value->content; ?><br>
																	<?php if ($value->user_id != 0 && $value->attach_file != NULL) {
																		echo '<p class="addition"><i class="fa fa-file-o"></i>';
																		echo substr($value->attach_file, 16).' - ';
																		echo '<a target="_blank" href="'.Yii::$app->params['site_url'].$value->attach_file.'">Download</a></p>';
																	}
																	elseif($value->user_id == Notify::ADMIN_ID && $value->attach_file != NULL){
																		echo '<p class="addition"><i class="fa fa-file-o"></i>';
																		echo substr($value->attach_file, 16).' - ';
																		echo '<a target="_blank" href="'.Yii::$app->params['site_url_front_end'].$value->attach_file.'">Download</a></p>';
																	} 
																	?>	
																</p>
															</div>
														<?php endforeach ?>									            
										            </li>
									            </ul>												
												<?php if (Yii::$app->session->hasFlash('success')) { ?>
										            <div class="alert alert-success" role="alert">
										                <?= Yii::$app->session->getFlash('success') ?>
										            </div>
										        <?php } ?>
												<?php $form = ActiveForm::begin(['options' => [ 'enctype' => 'multipart/form-data']]) ?>
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
												<?= Html::submitButton('Repply', ['class'=> 'btn btn-primary']) ;?>
												 <?php ActiveForm::end(); ?>
											</div>
										</div><!-- /.message-content -->										
									</div><!--message-list-container-->									
								</div>
							</div>
						</div><!-- /.tab-content -->
					</div><!-- /.tabbable -->
				</div><!-- /.col -->
			</div><!-- /.row -->
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->


