<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

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
					<div id="info" class="tab-pane fade active in">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 col-lg-offset-1">
                        	<img class="img-responsive" src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?=$bitcoinaddress?>" alt="QR Code">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

							<?php if(Yii::$app->session->hasFlash('error')): ?>
			                    <div class="alert alert-danger" role="alert">
			                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
			                        <?= Yii::$app->session->getFlash('error') ?>
			                    </div>
			                <?php endif; ?>

			                <?php if(Yii::$app->session->hasFlash('success')): ?>
			                    <div class="alert alert-success" role="alert">
			                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
			                        <?= Yii::$app->session->getFlash('success') ?>
			                    </div>
			                <?php endif; ?>

                            <h5 class="title-i">Blockchain Wallet Balance</h5>
                            <h3 class="green-number"><?=$balance?> BTC</h3>
                            <p>Wallet Address</p>
                            <form class="form-inline">
                                <div class="form-group has-feedback">
                                    <div class="input-group">                                                            
                                        <div aria-describedby="inputGroupSuccess3Status" id="inputGroupSuccess3" class="form-control"><?=$bitcoinaddress?></div>
                                        <span class="input-group-addon"><img src="http://bitway.giaonhanviec.com/images/icon-wallet-address.png"></span>
                                    </div>
                                </div>
                                
                            </form>
                            <h3></h3>
                            <?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
                            	<?= $form->field($TransferBitcoin, 'address', ['template' => '<div class="col-sm-12 text-left" for="form-field-1">Withdraw bitcoin address</div><div class="col-sm-12">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Address bitcoin', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>
                            	<?= $form->field($TransferBitcoin, 'amount', ['template' => '<div class="col-sm-12 text-left" for="form-field-1">Amount</div><div class="col-sm-12">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Amount', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>
                            	<?= Html::submitButton('<i class="ace-icon fa fa-paper-plane bigger-110"></i> Withdraw', ['class' => 'btn btn-success']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="clear-fix"></div>
                    </div>
                    <div class="clear-fix"></div>
				</div>
				<div class="clear-fix"></div>
				<h4></h4>
				<div class="col-md-12">
					<div class="table-responsive dynamic-table_wrapper">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
	                        <thead>
	                            <tr class="tr-green">
	                                <th data-sortable="false">Time</th>
	                                <th data-sortable="false">Bitcoin address</th>
	                                <th data-sortable="false">Type</th>
	                                <th data-sortable="false">Amount</th>                                                                                                
	                                <th data-sortable="false">Status</th>
	                                <th data-sortable="false">Details</th>
	                            </tr>
	                        </thead>
	                        
	                        <tbody>
	                        	<?php 
	                        	if(!empty($transactions)){
	                        		foreach ($transactions as $key => $transaction) {
	                        			if (!empty($transaction['blocktime'])){
		                                    $class = "color-complete";
		                                    $img = "icon-complete.png";
		                                    $status = "Complete";
		                                }else{ 
		                                    $class = "color-pending";
		                                    $img = "icon-pending.png";
		                                    $status = "Pending";
		                                }
		                                if($transaction['category']=="send") { 
		                                	$tx_type = '<b style="color: #FF0000;">Sent</b>'; 
		                                } else { 
		                                	$tx_type = '<b style="color: #01DF01;">Received</b>'; 
		                                }
	                        	?>
	                        	<tr>
	                                <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
	                                <td><?=$transaction['address']?></td>
	                                <td><?=$tx_type?></td>
                                    <td class="green-number"><strong><?=$transaction['amount']?> BTC</strong></td>                                                
                                    <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url_front_end'] ?>images/<?=$img?>"> <?=$status?></td>
                                    <td class="view-more-table blue">
                                        <i class="fa fa-chevron-circle-right"></i> 
                                        <a href="<?=Yii::$app->params['blockchain_url'].$transaction['txid']?>" title="" target="_blank">View more</a>
                                    </td>
	                            </tr>
	                        	<?php
	                        	} }else{
	                        		echo '<tr><td>No transaction</td></tr>';
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

<?php 
if(count($transactions) > 10){
	echo $this->registerJs("
		$('#dynamic-table').dataTable();
	");
}?>

<style type="text/css">
	#dynamic-table_filter{display: none;}
</style>
