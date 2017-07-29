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
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Token/Bitcoin</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Token được set bằng USD, hệ thống sẽ đổi sang BTC</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmConverttokentobitcoin" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<span class="help-block">Enter USD per 1 Token.</span>
										<label>1 Token = </label>
										<input type="number" step="0.0001" placeholder="Bitcoin" name="txt_bitpertoken" class="txt_bitpertoken" value="<?=$bitpertoken?>" required/> USD
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Ticket</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Ticket được set bằng USD, hệ thống sẽ đổi sang BTC</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmConvertticket" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<span class="help-block">Enter USD per 1 Ticket.</span>
										<label>1 Ticket = </label>
										<input type="number" placeholder="USD" name="txt_usdperticket" class="txt_usdperticket" value="<?=$usdperticket->value?>" required/> USD
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Token for user register</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Token được tặng cho mỗi user đăng ký mới</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmTokenregister" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<label>Token</label>
										<input type="number" min="0" placeholder="Bitcoin" name="txt_tokenregister" class="txt_tokenregister" value="<?=$tokenregister->value?>" required/>
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Standby time for gethelp</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Thời gian để một gh hoàn thành</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmStandbytime" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<label>Standby time</label>

										<input type="number" min="0" placeholder="Bitcoin" name="txt_standbytime" class="txt_standbytime" value="<?=$standbytimegh->value?>" required/> minutes
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Standby time for Block user</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Trong khoản thời gian user không hoạt động sẽ bị block account, hoạt động bao gồm: sendhelp, gethelp, buy token, transfer token.</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmStandbyforblock" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<label>Standby time</label>

										<input type="number" min="0" placeholder="Bitcoin" name="txt_standbyforblock" class="txt_standbyforblock" value="<?=$standbyforblock->value?>" required/> hour
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Fine amounts</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Trong khoản thời gian user không hoạt động sẽ bị block account, hoạt động bao gồm: sendhelp, gethelp, buy token, transfer token.</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmFineamounts" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<fieldset>
										<label>Fine amounts</label>

										<input type="number" step="0.0001" min="0" placeholder="Bitcoin" name="txt_fineamount" class="txt_fineamount" value="<?=$fineamount->value?>" required/> btc
									</fieldset>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- CHARITY  SETTING -->
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Charity setting</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Level Charity được tính bằng tổng số tiền đã đóng cho các chương trình từ thiện của hệ thống.</span>
						</div>
						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmCharitysetting" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<table class="table table-striped table-bordered table-hover" id="simple-table">
										<thead>
											<tr>
												<th>Level charity</th>
												<th>Amount</th>
											</tr>
										</thead>

										<tbody>
											<?php foreach ($charitysetting as $key => $value) { ?>
											<tr class="charitysetting">
												<td class="center">
													<?=$value->level;?>
												</td>
												<td>
													<input required type="number" step="0.01" class="amount" data="<?=$value->level?>" value="<?php if(!empty($value->amount)){echo $value->amount;}else{echo '0';}?>">
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!--END / CHARITY SETTING -->

				<!-- level min/max sh -->
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Amount Send help/Get help in a month</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Mặc định giá trị nhỏ nhất mỗi lần SH/GH là 0.1BTC</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding ">
								<form id="frmAmountgethelp" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="simple-table">
											<thead>
												<tr>
													<th>Level</th>
													<th>Amount SH</th>
													<th>Amount GH</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach ($amountgethelp as $key => $value) { ?>
												<tr class="dataamount">
													<td class="center">
														<?=$value->level;?>
													</td>
													<td>
														<input required type="number" class="amountsendhelp" data="<?=$value->level?>" value="<?php if(!empty($value->amountsh)){echo $value->amountsh;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="number" class="amountgethelp" data="<?=$value->level?>" value="<?php if(!empty($value->amountgh)){echo $value->amountgh;}else{echo '0';}?>">
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End level min/max sh -->
			</div>

			<div class="row">
				
				<!-- token for gh -->
				<div class="col-md-8 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Token for Gethelp</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Set số token cần có cho mỗi lần GH</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmTokenforgh" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="simple-table">
											<thead>
												<tr>
													<th rowspan="2">Token</th>
													<th text="text-center" colspan="2">Main wallet</th>
													<th text="text-center" colspan="2">Bonus wallet</th>
												</tr>
												<tr>
													
													<th>Min amount (<)</th>
													<th>Max amount (<=)</th>
													<th>Min amount (<)</th>
													<th>Max amount (<=)</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach ($tokenforgh as $key => $value) { ?>
												<tr class="tokenforgh">
													<td class="center">
														<?=$value->token;?>
													</td>
													<td>
														<input required type="text" class="min_mainw" data="<?=$value->token?>" value="<?php if(!empty($value->min_mainw)){echo $value->min_mainw;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="text" class="max_mainw" data="<?=$value->token?>" value="<?php if(!empty($value->max_mainw)){echo $value->max_mainw;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="text" class="min_bonusw" data="<?=$value->token?>" value="<?php if(!empty($value->min_bonusw)){echo $value->min_bonusw;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="text" class="max_bonusw" data="<?=$value->token?>" value="<?php if(!empty($value->max_bonusw)){echo $value->max_bonusw;}else{echo '0';}?>">
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End / token for gh -->


				<!-- token for sh/gh -->
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Token for Send help</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Số token cần có cho mỗi lần SH dựa vào số tiền SH.</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form action="javascript:;" id="frmTokenforsh">
									<!-- <legend>Form</legend> -->
									<div class="table-responsive">
										<table id="simple-table" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th rowspan="2">Token</th>
													<th>Min amount (<)</th>
													<th>Max amount (<=)</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach ($tokenforsh as $key => $token) { ?>
												<tr class="dataamount">
													<td class="center">
														<?=$token->token;?>											
													</td>
													<td>
														<input type="number" value="<?php if(!empty($token->min_amount)){echo $token->min_amount;}else{echo '0';}?>" data="<?=$token->token?>" class="min_amount" required="">
													</td>
													<td>
														<input type="number" value="<?php if(!empty($token->max_amount)){echo $token->max_amount;}else{echo '0';}?>" data="<?=$token->token?>" class="max_amount" required="">
													</td>
												</tr>	
												<?php } ?>							
											</tbody>
										</table>
									</div>

									<div class="form-actions center">
										
										<button type="submit" class="loading-btn btn btn-success" data-loading-text="Updating...">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End token for sh/gh -->


				<!--sh packet -->
				<div class="col-md-5 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">SendHelp packet</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Số ngày chờ và số ngày tối đa SH dựa theo số tiền SH</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmSendhelppacket" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="simple-table">
											<thead>
												<tr>
													<th></th>
													<th>Minday</th>
													<th>Maxday</th>
													<th>Minamount</th>
													<th>Maxamount</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach ($shpacket as $key => $packet) { ?>
												<tr class="sendhelppacket">
													<td>
														Packet <?=$key+1?>
													</td>
													<td>
														<input required type="number" class="minday" data="<?=$packet->id?>" value="<?php if(!empty($packet->min_days)){echo $packet->min_days;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="number" class="maxday" data="<?=$packet->id?>" value="<?php if(!empty($packet->max_days)){echo $packet->max_days;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="number" class="minamount" data="<?=$packet->id?>" value="<?php if(!empty($packet->min_amount)){echo $packet->min_amount;}else{echo '0';}?>">
													</td>
													<td>
														<input required type="number" class="maxamount" data="<?=$packet->id?>" value="<?php if(!empty($packet->max_amount)){echo $packet->max_amount;}else{echo '0';}?>">
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End sh packet -->

				<!--profit SH -->
				<div class="col-md-7 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Profit for SendHelp</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> lãi suất của SH được tính dựa trên số tiền một SH theo mỗi Sendhelp packet</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form id="frmProfitforsh" action="javascript:;">
									<!-- <legend>Form</legend> -->
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="simple-table">
											<thead>
												<tr>
													<th>Packet</th>
													<th>level 1 (%)</th>
													<th>level 2 (%)</th>
													<th>level 3 (%)</th>
													<th>level 4 (%)</th>
													<th>level 5 (%)</th>
													<th>level 6 (%)</th>
													<th>dont use(%)</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach ($profitforsh as $key => $profit) { ?>
												<tr class="profitforsh">
													<td>
														Packet <?=$key+1?>
													</td>
													<td>
														<input required step="0.01" type="number" class="staged1" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged1)){echo $profit->staged1;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged2" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged2)){echo $profit->staged2;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged3" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged3)){echo $profit->staged3;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged4" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged4)){echo $profit->staged4;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged5" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged5)){echo $profit->staged5;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged6" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged6)){echo $profit->staged6;}else{echo '0';}?>">
													</td>
													<td>
														<input required step="0.01" type="number" class="staged7" data="<?=$profit->packet_sh?>" value="<?php if(!empty($profit->staged7)){echo $profit->staged7;}else{echo '0';}?>">
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<div class="form-actions center">
										<button data-loading-text="Updating..." class="loading-btn btn btn-success" type="submit">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End profit SH -->
				

				<!-- referal bonus -->
				<div class="col-md-3 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Referal bonus</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Referal bonus được tính dựa vào level của người giới thiệu trực tiếp.</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form action="javascript:;" id="frmReferalbonus">
									<!-- <legend>Form</legend> -->
									<table id="simple-table" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Level</th>
												<th>Profit (%)</th>
											</tr>
										</thead>

										<tbody>
											<?php foreach ($referral as $key => $refer) { ?>
											<tr class="dataamount">
												<td class="center">
													<?=$refer->level;?>											
												</td>
												<td>
													<input type="number" step="0.01" value="<?php if(!empty($refer->profit)){echo $refer->profit;}?>" data="<?=$refer->level?>" class="referral_profit" required="">
												</td>
											</tr>	
											<?php } ?>							
										</tbody>
									</table>

									<div class="form-actions center">
										<button type="submit" class="loading-btn btn btn-success" data-loading-text="Updating...">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End referal bonus -->


				<!-- referal bonus -->
				<div class="col-md-3 col-sm-12 col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title">Manager bonus</h4>
							<span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Manager bonus được tính dựa vào số tầng mạng lưới giới thiệu, tối đa 12 tầng.</span>
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<form action="javascript:;" id="frmManagerbonus">
									<!-- <legend>Form</legend> -->
									<table id="simple-table" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Floor</th>
												<th>Profit (%)</th>
											</tr>
										</thead>

										<tbody>
											<?php foreach ($manager as $key => $mana) { ?>
											<tr class="dataamount">
												<td class="center">
													<?=$mana->floor;?>											
												</td>
												<td>
													<input type="number" step="0.01" value="<?php if(!empty($mana->profit)){echo $mana->profit;}?>" data="<?=$mana->floor?>" class="manager_profit" required="">
												</td>
											</tr>	
											<?php } ?>							
										</tbody>
									</table>

									<div class="form-actions center">
										
										<button type="submit" class="loading-btn btn btn-success" data-loading-text="Updating...">
											Update
											<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End referal bonus -->

			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->

	
</div>

<?=$this->registerJs("
	$('.loading-btn').on(ace.click_event, function () {
		var btn = $(this);
		btn.button('loading')
		setTimeout(function () {
			btn.button('reset')
		}, 2000)
	});
")?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmConverttokentobitcoin' ).submit(function( event ) {
	  	var txt_bitpertoken = $('.txt_bitpertoken').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatebtcpertoken', 
            data: {value:txt_bitpertoken}, 
            success: function (data) {
            }
        });
	});
})
");?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmConvertticket' ).submit(function( event ) {
	  	var txt_usdperticket = $('.txt_usdperticket').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updateusdperticket', 
            data: {value:txt_usdperticket}, 
            success: function (data) {
            }
        });
	});
})
");?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmTokenregister' ).submit(function( event ) {
	  	var txt_tokenregister = $('.txt_tokenregister').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatetokenregister', 
            data: {value:txt_tokenregister}, 
            success: function (data) {
            }
        });
	});
})
")?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmStandbytime' ).submit(function( event ) {
	  	var txt_standbytime = $('.txt_standbytime').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatestandbytime', 
            data: {value:txt_standbytime}, 
            success: function (data) {
            }
        });
	});
})
")?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmStandbyforblock' ).submit(function( event ) {
	  	var txt_standbyforblock = $('.txt_standbyforblock').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatestandbyforblock', 
            data: {value:txt_standbyforblock}, 
            success: function (data) {
            }
        });
	});
})
")?>

<?=$this->registerJs("
jQuery(function($) {
	$( '#frmFineamounts' ).submit(function( event ) {
	  	var txt_fineamount = $('.txt_fineamount').val();
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatefineamount', 
            data: {value:txt_fineamount}, 
            success: function (data) {
            }
        });
	});
})
")?>




<?=$this->registerJs("
jQuery(function(){
	$('#frmCharitysetting').submit(function(){
		var arr = [];
		var level = $('.charitysetting');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.amount').attr('data');
            var amount = $(level[i]).find('.amount').val();
            arr.push({id : id, amount : amount});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatecharitysetting', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
	})
})
")?>

<?=$this->registerJs("
jQuery(function($){
	$('#frmAmountgethelp').submit(function(){
		var arr = [];
		var level = $('.dataamount');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.amountsendhelp').attr('data');
            var sh = $(level[i]).find('.amountsendhelp').val();
            var gh = $(level[i]).find('.amountgethelp').val();
            arr.push({id : id, sh : sh, gh : gh});
		}

		$.ajax({
            type: \"POST\", 
            url:'/setting/updateamountgethelp', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });

	})
})
")?>


<?=$this->registerJs("
jQuery(function(){
	$('#frmTokenforgh').submit(function(){
		var arr = [];
		var level = $('.tokenforgh');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.min_mainw').attr('data');
			var min_mainw = $(level[i]).find('.min_mainw').val();
            var max_mainw = $(level[i]).find('.max_mainw').val();
            var min_bonusw = $(level[i]).find('.min_bonusw').val();
            var max_bonusw = $(level[i]).find('.max_bonusw').val();
            arr.push({id : id, min_mainw : min_mainw, max_mainw : max_mainw, min_bonusw : min_bonusw, max_bonusw : max_bonusw});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatetokenforgh', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
	})
})
")?>


<?=$this->registerJs("
jQuery(function($){
	$('#frmTokenforsh').submit(function(){
		var arr = [];
		var level = $('.dataamount');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.min_amount').attr('data');
            var min_amount = $(level[i]).find('.min_amount').val();
            var max_amount = $(level[i]).find('.max_amount').val();
            arr.push({id : id, min_amount : min_amount, max_amount : max_amount});
		}

		$.ajax({
            type: \"POST\", 
            url:'/setting/updatetokenforsh', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });

	})
})
")?>


<?=$this->registerJs("
jQuery(function(){
	$('#frmSendhelppacket').submit(function(){
		var arr = [];
		var level = $('.sendhelppacket');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.minday').attr('data');
			var minday = $(level[i]).find('.minday').val();
            var maxday = $(level[i]).find('.maxday').val();
            var minamount = $(level[i]).find('.minamount').val();
            var maxamount = $(level[i]).find('.maxamount').val();
            arr.push({id : id, minday : minday, maxday : maxday, minamount : minamount, maxamount : maxamount});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatesendhelppacket', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
	})
})
")?>


<?=$this->registerJs("
jQuery(function(){
	$('#frmProfitforsh').submit(function(){
		var arr = [];
		var packet = $('.profitforsh');
		for(var i = 0; i < packet.length; i++){
			var id = $(packet[i]).find('.staged1').attr('data');
			var staged1 = $(packet[i]).find('.staged1').val();
            var staged2 = $(packet[i]).find('.staged2').val();
            var staged3 = $(packet[i]).find('.staged3').val();
            var staged4 = $(packet[i]).find('.staged4').val();
            var staged5 = $(packet[i]).find('.staged5').val();
            var staged6 = $(packet[i]).find('.staged6').val();
            var staged7 = $(packet[i]).find('.staged7').val();
            arr.push({id : id, staged1 : staged1, staged2 : staged2, staged3 : staged3, staged4 : staged4, staged5 : staged5, staged6 : staged6, staged7 : staged7});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updateprofitforsendhelp', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
	})
})
")?>

<?=$this->registerJs("
jQuery(function(){
	$('#frmReferalbonus').submit(function(){
		var arr = [];
		var level = $('.dataamount');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.referral_profit').attr('data');
            var amount = $(level[i]).find('.referral_profit').val();
            arr.push({id : id, amount : amount});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatereferral', 
            data: {arr:arr}, 
            success: function (data) {
            	alert(data);
            }
        });
	})
})
")?>


<?=$this->registerJs("
jQuery(function(){
	$('#frmManagerbonus').submit(function(){
		var arr = [];
		var level = $('.dataamount');
		for(var i = 0; i < level.length; i++){
			var id = $(level[i]).find('.manager_profit').attr('data');
            var amount = $(level[i]).find('.manager_profit').val();
            arr.push({id : id, amount : amount});
		}
		$.ajax({
            type: \"POST\", 
            url:'/setting/updatemanager', 
            data: {arr:arr}, 
            success: function (data) {
            }
        });
	})
})
")?>



