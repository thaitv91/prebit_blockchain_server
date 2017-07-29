<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\TicketTransfer;

$this->title = 'Ticket Transfers';
$this->params['breadcrumbs'][] = $this->title;
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
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="5" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
                                <img src="<?=Yii::$app->params['site_url'];?>images/ticket/t10.png" alt="">                  
                                <div class="radio">
                                    <label>
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="10" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
                                <img src="<?=Yii::$app->params['site_url'];?>images/ticket/t15.png" alt="">                  
                                <div class="radio">
                                    <label>
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="15" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
                                <img src="<?=Yii::$app->params['site_url'];?>images/ticket/t20.png" alt="">                  
                                <div class="radio">
                                    <label>
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="20" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
                                <img src="<?=Yii::$app->params['site_url'];?>images/ticket/t25.png" alt="">                  
                                <div class="radio">
                                    <label>
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="25" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 bitem">
                                <img src="<?=Yii::$app->params['site_url'];?>images/ticket/t30.png" alt="">                  
                                <div class="radio">
                                    <label>
                                        <input class="optionsticket" type="radio" name="optionsticket" id="optionsRadios1" value="30" checked>
                                    </label>
                                </div>
                            </div><!--b-item-->
                        </div><!--col-lg-6-->
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 right-usd">
                            <div class="title-choose">
                                <h4>Choose Ticket to buy :</h4>
                            </div> 
                            <div class="on-pay">
                                <input id="number_ticket" type="number" min="0" onkeypress='isNumberKey(event)'  >
                                <button class="btn btn-success">TICKET</button> <span class="nuts">= </span>
                                <input id = "convert_usd" type="number" name="" disabled>
                                <button class="btn btn-success">USD</button><span class="nuts"> = </span>
                                <input id="convert_bitcoin" type="number" name="" disabled>
                                <button class="btn btn-success">BTC</button>
                                <p class="ticket-alert text-red"></p>
                            </div>
                            <div class="bottom-pay">
                                <button  class="buy_ticket btn btn-default">SUBMIT</button>
                            </div>   
                        </div>
                    </div>                                      
                </div>
            </div>
        </div>
    </div>
</div><!--bitcoin-history-->
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
                                <th data-sortable="false">Ticket</th>  
                                <th data-sortable="false">Amount</th>                                                                                                
                                <th data-sortable="false">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($buyticket)){
                                foreach ($buyticket as $ticketbuy) {
                            ?>
                            <tr>
                                <td><?=$ticketbuy->id + 1000?></td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td><?=$ticketbuy->amount?></td>
                                <td class="green-number"><strong><?=number_format($ticketbuy->bitcoin, 8)?> BTC</strong></td>                                  
                                <td><?=date('d-m-Y H:i', $ticketbuy->created_at)?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>                                      
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
                            <?php 
                            if(!empty($useticket)){
                                foreach ($useticket as $ticketuse) {
                            ?>
                            <tr>
                                <td><?=$ticketuse->id + 1000?></td>
                                <td class="color-complete"><img src="<?=Yii::$app->params['site_url'];?>images/icon-complete.png"> Complete</td>
                                <td class="green-number"><strong><?=number_format($ticketuse->bitcoin, 8)?> BTC</strong></td>                                  
                                <td><?=date('d-m-Y H:i', $ticketuse->created_at)?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>          
                                                        
                        </tbody>
                    </table>
                </div>
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->
    </div>
</div><!--bitcoin-history-->

<div class="modal fade bs-example-modal-md" id="otp_token" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">OTP code for Ticket transfer</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <form>
                    <div class="">
                        <label>OTP code</label>
                        <input type="text" class="form-control code_otptickettransfer" placeholder="Enter OTP code here">
                        <p class="otp_code_alert"></p>
                    </div>
                    <div class="button-donate">
                        <button type="button" id="submit_otpcode" class="btn btn-donate">SUBMIT</button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-md" id="success_tickettransfer" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Ticket transfer</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <p class="bottom-donate">
                    Ticket transfer was successful
                </p>
                <div class="button-donate">
                    <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>    
        </div>
    </div>
</div>

<?=$this->registerJs("
    $('input[name=\"optionsticket\"]').change(function(e) {
        var optionsticket = $(this).val();
        var usdperticket = ".$usdperticket->value.";
        var bitcoinperusd = ".$bitcoinperusd.";
        var usd = optionsticket * usdperticket;
        var bitcoin = usd * bitcoinperusd;
        $('#number_ticket').val(optionsticket);
        $('#convert_usd').val(usd);
        $('#convert_bitcoin').val(bitcoin);
    })
")?>

<?=$this->registerJs("
    $('#number_ticket').keyup(function(e) {
        var ticket = $(this).val();
        var usdperticket = ".$usdperticket->value.";
        var bitcoinperusd = ".$bitcoinperusd.";
        var usd = ticket * usdperticket;
        var bitcoin = usd * bitcoinperusd;
        $('#convert_usd').val(usd);
        $('#convert_bitcoin').val(bitcoin);
    })
")?>

<?=$this->registerJs("
    $('.buy_ticket').click(function(e) {
        var balance = ".$balance.";
        var ticket = $('#number_ticket').val();
        var usdamount = $('#convert_usd').val();
        var bitcoinamount = $('#convert_bitcoin').val();
        var user = ".Yii::$app->user->identity->id.";
        
        if(!ticket || ticket < 1){
            $('.ticket-alert').html('Enter the quantity of tickets you want to purchase');
            $('#number_ticket').focus();
            return false;
        } else if (balance <= bitcoinamount){
            $('.ticket-alert').html('Your Bitway wallet not enough.');
            $('#number_ticket').focus();
            return false;
        }else{
            $('.ticket-alert').html('');
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/tickettransfer/buyticket', 
                data: {user : user, ticket : ticket, bitcoinamount : bitcoinamount}, 
                success: function (data) {
                    if(data){
                        $('.code_otptickettransfer').attr(\"data\", data);
                        $('#otp_token').modal();
                    }
                }
            });
        }
    })
")?>


<?=$this->registerJs("
    $('#submit_otpcode').click(function(){
        var otp_code = $('.code_otptickettransfer').val();
        var id_ticketrequest = $('.code_otptickettransfer').attr('data');
        if(!otp_code){
            $('.otp_code_alert').html('<p class=\"text-red\">Please enter OTP code!</p>')
            $('.code_otptickettransfer').focus();
            return false;
        } else {
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/tickettransfer/confirm_otpcode', 
                data: {id_ticketrequest : id_ticketrequest, otp_code : otp_code}, 
                success: function (data) {
                    if(data){
                        $('.otp_code_alert').html('<p class=\"text-red\">OTP code incorrect!</p>')
                        $('.code_otptickettransfer').focus();
                        return false;
                    } else {
                        $('#otp_token').hide();
                        $('#success_tickettransfer').modal();
                    }
                }
            });
        }
    })
")?>


