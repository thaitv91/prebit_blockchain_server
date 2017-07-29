<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BitcoinWallet;
?>
<div class="page-content">
	<div class="page-header">
		<h1>
			Bitcoin Wallet System
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?=$type?>
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<?= $form->field($model, 'username', ['template' => '{input}{hint}{error}'])->textInput(['placeholder'=>'User name',])->label(false) ?>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<?= Html::submitButton('Create', ['class' => 'btn btn-success' ]) ?>
						</div>
					<?php ActiveForm::end(); ?>
					<div class="clear-fix"></div>
					<h2></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
                        <table class="table" data-sortable="">
	                        <thead>
	                            <tr class="tr-green">
	                            	<th data-sortable="false">Account</th>
	                            	<th data-sortable="false">Balance</th>
	                                <th data-sortable="false">Address</th>
	                                <th data-sortable="false">QR Code</th>
	                                <th data-sortable="false">Publish</th>
	                                <th></th>
	                            </tr>
	                        </thead>
	                        
	                        <tbody>
	                        	<?php 
	                        	foreach ($BitcoinWallet as $key => $bitwallet) {
	                        		if ($bitwallet->username == "" ) {
	                        	?>
	                        		<tr>
		                                <td><?=$bitwallet->username;?></td>
		                                <td><?=$client->getBalance($bitwallet->username)?></td>
		                                <td><?=$client->getAddress($bitwallet->username)?></td>
		                                <td>
		                                	<img width="60" class="img-responsive" src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?=$client->getAddress('btcwallet'.$bitwallet->username)?>" alt="QR Code">
		                                </td> 
		                                <td>
		                                	<?php 
		                                	 if ($bitwallet->publish == BitcoinWallet::PUBLISH_ACTIVE){
		                                        $check = 'checked';
		                                        $act = 'close';
		                                    } else {
		                                        $check = '';
		                                        $act = 'opent';
		                                    }
		                                    echo '<input name="publish" class="ace ace-switch ace-switch-6 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$bitwallet->id.' /><span class="lbl"></span>';
	                                
		                                	?>
		                                </td>                         
		                                <td class="text-blue">
		                                	<?=Html::a('<i class="fa fa-chevron-circle-right"></i> View more', '/bitcoinwallet/view/'.$bitwallet->id, ['title' => Yii::t('app', 'View')]);?>
	                                    </td>
		                            </tr>
	                        	<?php
	                        		} else {		
	                        	?>
		                        	<tr>
		                                <td><?=$bitwallet->username;?></td>
		                                <td><?=$client->getBalance('btcwallet'.$bitwallet->username)?></td>
		                                <td><?=$client->getAddress('btcwallet'.$bitwallet->username)?></td>
		                                <td>
		                                	<img width="60" class="img-responsive" src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?=$client->getAddress('btcwallet'.$bitwallet->username)?>" alt="QR Code">
		                                </td> 
		                                <td>
		                                	<?php 
		                                	 if ($bitwallet->publish == BitcoinWallet::PUBLISH_ACTIVE){
		                                        $check = 'checked';
		                                        $act = 'close';
		                                    } else {
		                                        $check = '';
		                                        $act = 'opent';
		                                    }
		                                    echo '<input name="publish" class="ace ace-switch ace-switch-6 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$bitwallet->id.' /><span class="lbl"></span>';
	                                
		                                	?>
		                                </td>                         
		                                <td class="text-blue">
		                                	<?=Html::a('<i class="fa fa-chevron-circle-right"></i> View more', '/bitcoinwallet/view/'.$bitwallet->id, ['title' => Yii::t('app', 'View')]);?>
	                                    </td>
		                            </tr>
	                        	<?php
				                        }
	                        	}
	                        	?>                                
	                        </tbody>
	                    </table>
	                </div>
	            </div>    
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["bitcoinwallet/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>



