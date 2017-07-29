<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use backend\controllers\MemberController;
use common\models\User;
use common\models\Notify;
?>
<div class="page-content">

	<div class="page-header">
		<h1>
			Sent
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
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
												<span class="blue bigger-150">Sent</span>
												<span class="grey bigger-110">(22 messages)</span>
											</div>
										</div>

										<div>
											<div class="messagebar-item-left">
												<label class="inline middle">
													<input type="checkbox" id="id-toggle-all" class="ace" />
													<span class="lbl"></span>
												</label>

												&nbsp;
												<div class="inline position-relative">
												</div>
											</div>

											<div class="messagebar-item-right">
											</div>

											<div class="nav-search minimized">
												<form class="form-search">
													<span class="input-icon">
														<input type="text" autocomplete="off" class="input-small nav-search-input" placeholder="Search inbox ..." />
														<i class="ace-icon fa fa-search nav-search-icon"></i>
													</span>
												</form>
											</div>
										</div>
									</div>
									<div class="message-list-container">
										<div class="message-list" id="message-list">
											<div class="table-responsive">					
												<?=
								                    GridView::widget([
								                        'id' => 'girdMessage',
								                        'dataProvider' => $dataProvider,
								                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
								                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
								                        'rowOptions'=>function($data){
													            return [
															        'id'      => $data['id'], 
															        'onclick' => 'location.href="' 
															            . Yii::$app->urlManager->createUrl('message/view') 
															            .'?id="+(this.id);',
															    ];
													            
													    },
								                        'columns' => [
								                            [
								                                'class' => 'yii\grid\CheckboxColumn',
								                                'multiple' => true,
								                            ],
								                            [
								                                'label' => 'Sender',
								                                'format' => 'html',
								                                'value' => function ($data) {
								                                	if ($data->publish == Notify::PUBLISH_NOACTIVE) {
								                                		$datasuser = User::findOne($data->user_id);
								                                		return $datasuser->username;
								                                	}
								                                	else{
								                                		return 'Admin';
								                                	}
								                                    
								                                },
								                            ],
								                            [
								                                'label' => 'Title',
								                                'format' => 'html',
								                                'value' => function ($data) {	                                
								                                    if ($data->publish == Notify::PUBLISH_NOACTIVE) {
								                                    	return '<span class="label label-danger">New</span>&nbsp;'.$data->title;
								                                	}
								                                	else{
								                                		return $data->title;
								                                	}
								                                },
								                            ],
								                            [
								                                'label' => 'Time',
								                                'format' => 'html',
								                                'value' => function ($data) {
								                                	if ($data->publish == Notify::PUBLISH_NOACTIVE) {
								                                    	return '<b>'.time('H:i',$data->created_at).'</b>';
								                                	}
								                                	else{
								                                		return Yii::$app->convert->time($data->created_at);
								                                	}
								                                    
								                                },
								                            ],
								                        ],
								                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
								                    ]);
							                    ?>
											</div><!-- End div .table-responsive -->										
										</div>
									</div>

									
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


				