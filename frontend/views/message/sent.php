<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use backend\controllers\MemberController;
use yii\grid\GridView;
use common\models\User;
use common\models\Notify;

$this->title = 'Message sent';
?>
<div class="page-heading">
	<!-- <h1><i class='fa fa-envelope'></i> E-mail</h1> -->
</div>
<!-- Page Heading End-->
<!-- Begin Inbox -->
<div class="no-margin widget transparent box-messages">
	<h1 class="title-maillist"><i class='fa fa-envelope'></i> E-mail</h1>
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
			<div class="mail-list">				
				<div class="table-responsive">
					<div class="col-lg-6">
                        <div id="lis-toolbar" class="btn-toolbar" role="toolbar">                            
	                        <div class="mail-option">
	                            <div class="chk-all">
	                                <div class="btn-group">
	                                    <?php echo Html::a('<i class="fa fa-inbox"></i> Compose', '/message/compose/', ['class'=>'btn mini all', 'data-toggle'=>'tooltip', 'title'=>'Compose']) ?>
	                                </div>
	                            </div>

	                            <div class="btn-group">
	                                <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips">
	                                    <i class=" fa fa-refresh"></i>
	                                </a>
	                            </div>
	                            <div class="btn-group hidden-phone">
	                                <?= Html::a('<i class="fa fa-trash-o"></i> Delete', "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-success", "data-toggle"=>"tooltip", 'title'=>'Delete']) ?>
	                            </div>	                                                     
	                        </div>
	                    </div>
                    </div>			
					<?=
	                    GridView::widget([
	                        'id' => 'girdMessage',
	                        'dataProvider' => $dataProvider,
	                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
	                        'rowOptions' => function($data){
						        if ($data->publish == Notify::PUBLISH_NOACTIVE) {

						            return ['class' => 'danger'];
						        }
						    },


	                        'columns' => [
	                            [
	                                'class' => 'yii\grid\CheckboxColumn',
	                                'multiple' => true,
	                                'contentOptions' => ['class' => 'width20'],
	                            ],
	                            [
	                                'label' => 'Sender',
	                                'format' => 'html',
	                                'value' => function ($data) {
	                                	if ($data->publish == Notify::PUBLISH_NOACTIVE) {
	                                		return 'Admin';
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
	                                    	return Html::a('<span class="label label-danger">New</span>&nbsp;'.$data->title,['message/view','id'=>$data->id],['title'=>'Go!','target'=>'_blank']);
	                                	}
	                                	else{
	                                		return Html::a($data->title,['message/view','id'=>$data->id],['title'=>$data->title,'target'=>'_blank']);
	                                	}
	                                },
	                            ],
	                            [
	                                'label' => 'Time',
	                                'contentOptions' => ['class' => 'width100'],
	                                'format' => 'html',
	                                'value' => function ($data) {
	                                	if ($data->publish == Notify::PUBLISH_NOACTIVE) {
	                                		$today = strtotime(date('Y-m-d'));
	                                		if ($today > $data->created_at) {
	                                    		return '<b>'.date('d M',($data->created_at)).'</b>';
	                                    	}else{
	                                    		return '<b>'.date('H:i A',($data->created_at)).'</b>';
	                                    	}
	                                	}
	                                	else{
	                                		$today = strtotime(date('Y-m-d'));
	                                		if ($today > $data->created_at) {
	                                			return  date('d M',($data->created_at));
	                                		}else{
	                                			return  date('H:i A',($data->created_at));
	                                		}
	                                		
	                                	}
	                                    
	                                },
	                            ],
	                        ],
	                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
	                    ]);
                    ?>
				</div><!-- End div .table-responsive -->
			</div>
		</div><!-- End div .col-md-10 -->
	</div><!-- End div .row -->
</div><!-- End div .box-info -->
<!-- End inbox -->

<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
        var keys = $("#girdMessage").yiiGridView("getSelectedRows");
        if(keys==""){
            var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có muốn xóa các mẫu tin này không (s)");
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