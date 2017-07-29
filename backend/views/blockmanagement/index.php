<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlockList;
use common\models\User;
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
                            		return Html::a($data->username, '/user/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'target'=>'_blank']);
                            	}
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Amount',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data){
                                    $block = $data->getblock($data->id);
                            		return $block["amount"].' Btc';
                            	}
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Created at',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'hidden-480'],
                                'contentOptions' => ['class' => 'hidden-480'],
                                'value' => function($data) {
                                	return date('H:i d/m/Y', $data->timeblock);
                                }
                            ],
                            [
                            	'attribute' => '',
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    $block = $data->getblock($data->id);
                                  	if($block["status"] == BlockList::BLOCK_ACTIVE){
									 	$status = '<span class="label label-sm label-danger">Block</span>';
									} else {
										$status = '<span class="label label-sm label-success">Unblock</span> at '.date('H:i d/m/Y', $block["updated_at"]);
									}
                                	return $status;
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Unblock',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    $block = $data->getblock($data->id);
                                    if ($block["status"] == BlockList::BLOCK_NOACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                        return '<input name="block" class="ace ace-switch ace-switch-6 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                                    }else{
                                    	return '';
                                    }
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

<?= $this->registerJs('
$("input[name=block]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["user/block"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>
