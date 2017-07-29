<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use backend\controllers\MemberController;
use yii\grid\GridView;
use common\models\User;
use common\models\Notify;
?>
<div class="page-content">
	<div class="page-header">
		<h1>
			Inbox
		</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<div class="tab-content no-border no-padding">
							<div id="inbox" class="tab-pane in active">
								<div class="message-container">
									<div id="id-message-list-navbar" class="message-navbar clearfix">
										<div class="pull-left">
											<?php echo Html::a('<i class="fa fa-pencil"></i>', '/message/compose/', ['class'=>'btn btn-primary', 'data-toggle'=>'tooltip', 'title'=>'Compose']) ?>
											<?= Html::a('<i class="fa fa-trash-o"></i>', "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger", "data-toggle"=>"tooltip", 'title'=>'Delete']) ?>
										</div>
										<div class="message-bar">
											<div class="message-infobar" id="id-message-infobar">
												
												<span class="blue bigger-150">Inbox</span>
												<span class="grey bigger-110"><?= number_format($countmessage, 0, '', '.') ?> unread messages)</span>
											</div>											
										</div>
									</div>
									<div class="message-list-container">
										<div class="message-list" id="message-list">
											<?=GridView::widget([
							                        'id' => 'girdMessage',
							                        'dataProvider' => $dataProvider,
							                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
							                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",

							                        'columns' => [
							                            [
							                                'class' => 'yii\grid\CheckboxColumn',
							                                'multiple' => true,
							                            ],
							                            [
							                                'label' => 'Sender',
							                                'format' => 'html',
							                                'value' => function ($data) {							                                	
						                                		$datasuser = User::findOne($data->user_id);
						                                		if ($data->user_id == 0) {
						                                			return 'Admin';
						                                		}else{
						                                			return $datasuser->username;
						                                		}
							                                },
							                            ],
							                            [
							                                'label' => 'Title',
							                                'format' => 'html',
							                                'value' => function ($data) {								                                	                                
							                                    if ($data->publish == Notify::PUBLISH_NOACTIVE) {							                                    	
							                                    	return Html::a('<span class="label label-danger">New</span>&nbsp;'.$data->title,['message/view','id'=>$data->id],['title'=>'Go!','target'=>'_blank']);
							                                	}
							                                	else{
							                                		return Html::a($data->title,['message/view','id'=>$data->id],['title'=>$data->title,'target'=>'_blank']);
							                                	}
							                                },
							                            ],
							                            [
							                                'label' => 'Time',
							                                'format' => 'html',
							                                'value' => function ($data) {
							                                	if ($data->publish == Notify::PUBLISH_NOACTIVE) {
							                                    	return '<b>'.Yii::$app->convert->time($data->created_at).'</b>';
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
										</div>
									</div>
								</div>
							</div>
						</div><!-- /.tab-content -->
					</div><!-- /.tabbable -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
        var keys = $("#girdMessage").yiiGridView("getSelectedRows");
        if(keys==""){
            var msg = confirm("You have not selected any news item");
        } else {
            var msg = confirm("Do you want to delete this message (s)");
        }
        if (msg == true) {
            if(keys!=""){
                var url = "' . Yii::$app->urlManager->createUrl(["message/delete"]) . '";  
                window.location.href = url + "?id=" + keys;  
            }
        }
        return false;
    });
');?>

		