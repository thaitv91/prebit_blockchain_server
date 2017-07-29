<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\TokenRequest;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>TICKET</h2>
         Buy, transfer and check your token transaction history on this page
    </div>                    
</div>

<div class="row token-history token-manager">
    <div class="col-md-12">
        <div class="bg-white">
            <div class="title-token-history">
                <h3>Buy Ticket</h3>
                <p>You currently have 0 available tokens. Last updated on 03/07/2016 12:23 AM</p>
            </div>
            <div class="widget">
                <div class="widget-content">
                	<div class="row">
                		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title-choose">
                				<h4>Choose Ticket to buy :</h4>
                			</div>                			
                			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t5.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t10.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
		                	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t15.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
		                	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t20.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
		                	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t25.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
		                	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
		                		<img src="<?=Yii::$app->params['site_url'];?>images/ticket/t30.png" alt="">                  
			                    <div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									</label>
								</div>
		                	</div><!--b-item-->
                		</div><!--col-lg-6-->
                		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 right-usd">
                			<div class="title-choose">
                				<h4>Choose Ticket to buy :</h4>
                			</div> 
                			<div class="on-pay">
	                			<select>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
								<button class="btn btn-success">TICKET</button> <span class="nuts">= </span>
								<input id = "number-ticket" type="number" name="">
								<button class="btn btn-success">USD</button><span class="nuts"> = </span>
								<input id="number-btc" type="number" name="">
								<button class="btn btn-success">BTC</button>
							</div>
							<div class="bottom-pay">
								<form class="form-inline">
									<div class="form-group">
										<label for="exampleInputName2">OTP Password : </label>
										<input type="text" class="form-control" id="exampleInputName2" placeholder="">
									</div>
									<button type="submit" class="btn btn-default">SUBMIT</button>
								</form>
							</div>
                		</div>
                	</div>	                	               	
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->
<div class="row bitcoin-wallet-history">
    <div class="widget-content padding">
        <ul id="history-wallet" class="nav nav-tabs">
            <li class="active">
                <a href="#with-history" data-toggle="tab">BUY HISTORY</a>
            </li>
            <li class="">
                <a href="#deposit-history" data-toggle="tab">USE TICKET HISTORY</a>
            </li>                            
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="with-history">
                <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr class="tr-green">
                                <th data-sortable="false">Invoice</th>
                                <th data-sortable="false">Status</th>
                                <th data-sortable="false">Amount</th>                                                                                                
                                <th data-sortable="false">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr>
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr>                                                    
                        </tbody>
                    </table>
                </div>
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="deposit-history">
                <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr class="tr-green">
                                <th data-sortable="false">Invoice</th>
                                <th data-sortable="false">Status</th>
                                <th data-sortable="false">Amount</th>                                                                                                
                                <th data-sortable="false">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr>
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr> 
                            <tr>
                                <td>1234567</td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong>0.00023564 BTC</strong></td>                                  
                                <td>1234567</td>
                            </tr>                                    
                        </tbody>
                    </table>
                </div>
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->
    </div>
</div><!--token-history-->

<?=$this->registerJs("
    var select_ticket = $('input:radio[name=gender]:checked').val();
    alert(select_ticket);
")?>

