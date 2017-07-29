<?php 
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\ConvertBitcoin;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
$cookies = Yii::$app->request->cookies;
if ($cookies->has('btcaddress'))
$btcaddress_val =  $cookies->getValue('btcaddress');
else
$btcaddress_val = '';
$connection = \Yii::$app->db;
$sql = "SELECT * FROM external_email_address WHERE user_id = ".Yii::$app->user->identity->id;
$external_email_address = $connection->createCommand($sql)->queryOne(); 
if(isset($external_email_address['email']))
$saved_email = $external_email_address['email'];
else
$saved_email  = '';
$this->title = 'Bitcoin Wallet - PreBit';
?>

<div class="top-dashboard no-margin-bottom-xs">
    <h2 class="title-general">BITCOIN WALLET</h2>                   
</div>

<div class="row token-history token-manager">
    <div class="col-md-12">
        <div class="bg-white">
            <div class="widget">
                <div class="widget-content">   

                    <!-- alert -->
                    <?php if(Yii::$app->session->hasFlash('cashwithdraw')): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            <?= Yii::$app->session->getFlash('cashwithdraw') ?>
                        </div>
                    <?php endif; ?>
                    <!-- END alert -->

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="your-cash-box yellow">
                                <h4>PreBit Wallet Balance</h4>
                                <h4 class="green-number"><?=number_format($balance_btc, 8);?> BTC</h4>
                                <div class="" id="info">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="">                                        
                                                <p><?=Yii::$app->languages->getLanguage()['wallet_address'];?></p>
                                                <form class="form-inline">
                                                    <div class="form-group has-feedback">
                                                        <div class="input-group">                                                            
                                                            <div class="form-control" id="inputGroupSuccess3" aria-describedby="inputGroupSuccess3Status"><?=$address_btc[0]?></div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-8">
                                                        <div class="wallet-text">
                        Above is the address of your PreBit wallet, the equivalent QR code of this wallet is also provided. You will need to deposit BTC into this PreBit wallet to buy Fee and Deposit. You will also need to use this PreBit wallet to withdraw your BTC to your external Bitcoin wallets hosted somewhere else.
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-4 visible-xs">
                                                        <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=<?=$address_btc[0]?>" alt="QR Code" class="img-responsive">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-4 hidden-xs">
                                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=<?=$address_btc[0]?>" alt="QR Code" class="img-responsive">
                                        </div>
                                    </div>
                                </div> <!-- / #info -->
                            </div><!-- your-cash-box -->
                        </div><!-- col-md-4 -->

                        <div class="col-md-4 col-sm-6">
                            <div class="your-cash-box dark">
                                <h4><?=Yii::$app->languages->getLanguage()['btc_withdraw'];?></h4>
                                <div class="" id="btc-width-draw">
                                    <?php
                                    if(Yii::$app->user->identity->publish == User::PUBLISH_NOACTIVE){
                                    ?>
                                    <div class="alert alert-danger">
                                        <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> Your account has not been verified. Please navigate to your Profile page to verify your account.
                                    </div>
                                    <?php   
                                    } else {
                                    ?>
                                    
                                    <?php $form = ActiveForm::begin(['id' => 'WithdrawBitcoin']); ?>
                                       
                                        <?php if($balance_btc - 0.0005 <= 0)
                                        { 
                                            echo '<p>'.Yii::$app->languages->getLanguage()["your_balance_is_not_enough_to_withdraw"].'</p>';
                                        } else
                                            { 
                                                echo '<p>'.Yii::$app->languages->getLanguage()["you_can_withdraw_up_to"].' <b>';
                                                echo $balance_btc - 0.0005;
                                                echo '</b> BTC</p>';
                                            }
                                        ?>
                                        <div id="withdraw_alert" class="alert-system alert alert-success col-md-12">
                                            <?="chưa active"?>
                                        </div>
                                        <div class="row paddtop10">
                                            <div id="form-hide-request">
                                                <div class="col-xs-12">
                                                    <label>External Wallet Address</label>
                                                   <?php  $WithdrawBitcoin->btcaddress = $saved_email; ?>
                                                    <?= $form->field($WithdrawBitcoin, 'btcaddress', ['template' => '<div class="pos-re">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'External Wallet Address', 'class' => 'form-control input-sm btcaddress', 'required' => 'required'])->label(false) ?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <label>Withdrawal Amount</label>
                                                    <?= $form->field($WithdrawBitcoin, 'amount', ['template' => '<div class="fg-line">{input}<span class="prefix right">BTC</span> {hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Withdrawal Amount', 'class' => 'form-control input-sm amount', 'required' => 'required'])->label(false) ?>        
                                                </div>                                   
                                                <div class="btn-group pull-right">
                                                    <a id="click-to-withdraw" class="btn btn btn-gh"><?=Yii::$app->languages->getLanguage()['request_transfer'];?></a>
                                                </div>
                                            </div>
                                            <div id="form-show-request">
                                                <div class="col-xs-12">
                                                    <div class="form-group ">
                                                        <div class="fg-line">
                                                            <input type="text" class="form-control input-sm" placeholder="External Wallet Address">
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12"> 
                                                    <div class="form-group">
                                                        <div class="fg-line">
                                                            <input type="number" name="amount" placeholder="Withdrawal Amount" class="form-control input-sm"><span class="prefix right">BTC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">    
                                                    <div class="form-group">
                                                        <div class="fg-line">
                                                            <input type="text" class="form-control input-sm" placeholder="OTP Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">    
                                                    <div class="form-group btn-group pull-right">
                                                        <a href="#" class="btn btn btn-gh"><?=Yii::$app->languages->getLanguage()['proceed_transfer'];?></a>
                                                    </div>
                                                </div>    
                                            </div><!--form-show-request-->
                                        </div><!--row-->
                                    <?php ActiveForm::end(); ?>
                                    <?php }?>
                                </div> <!-- / #btc-width-draw -->
                            </div><!-- your-cash-box -->
                        </div><!-- col-md-4 -->

                        <div class="col-md-4 col-sm-6">
                            <div class="your-cash-box pink">
                                <h4><?=Yii::$app->languages->getLanguage()['buy_btc'];?></h4>

                                <div class="" id="buy-btc">
                                    <p><?=Yii::$app->languages->getLanguage()["find_where_to_buy_btc_in_your_country"]?></p>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <div class="fg-line">
                                                    <label><?=Yii::$app->languages->getLanguage()["choose_country"]?>:</label>
                                                    <select class="form-control" id="select-country">
                                                        <?php
                                                        foreach ($buyBtc as $key => $buyBtc) {
                                                            echo '<option value="'.$buyBtc->findCountry($buyBtc->country_id)->id.'">'.$buyBtc->findCountry($buyBtc->country_id)->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h4 class="title-i"><?=Yii::$app->languages->getLanguage()["buy_btc_address"]?>:</h4>
                                            <ul class="list-unstyled list_address">
                                                <?php
                                                foreach ($listAddress as $key => $address) {
                                                    echo '<li><a href="'.$address->address.'" target="_blank">'.$address->address.'</a></li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div><!--row-->                                                
                                </div> <!-- / #buy-btc -->
                            </div><!-- your-cash-box -->
                        </div><!-- col-md-4 -->

                        <div class="col-xs-12">
                            <div class="your-cash-box bg-dark-gray">
                                <h4><?=Yii::$app->languages->getLanguage()['cash_withdraw'];?></h4>
                                <div class="" id="btc-cash-draw">
                                    <?php $form = ActiveForm::begin(['id' => 'Cashwithdraw']); ?>
                                        
                                      
                                        <?php if($balance_btc - 0.0005 <= 0)
                                        { 
                                            echo '<p>'.Yii::$app->languages->getLanguage()["your_balance_is_not_enough_to_withdraw"].'</p>';
                                        } else
                                            { 
                                                echo '<p>'.Yii::$app->languages->getLanguage()["you_can_withdraw_up_to"].' <b>';
                                                echo $balance_btc - 0.0005;
                                                echo '</b> BTC</p>'; 
                                            }
                                        ?>
                                        <div id="cashwithdraw_alert" class="alert-system alert alert-success col-md-12"></div>
                                        <div class="row paddtop10">
                                            <div id="form-cash-draw">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12">
                                                            <label>Select country</label>
                                                        <?= $form->field($Cashwithdraw, 'currency', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->dropDownList($Cashwithdraw->listCurrency, ['class' => 'form-control select_currency txt_country'])->label(FALSE); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12">
                                                            <?= $form->field($Cashwithdraw, 'bank_name', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Name', 'class' => 'form-control input-sm txt_bankname', 'required' => 'required'])->label(false) ?>
                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-xs-12">   
                                                            <?= $form->field($Cashwithdraw, 'recepient_name', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Recepient Name', 'class' => 'form-control input-sm txt_recepientname', 'required' => 'required'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12"> 
                                                            <?= $form->field($Cashwithdraw, 'bank_account', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Account Number', 'class' => 'form-control input-sm txt_bankaccount', 'required' => 'required'])->label(false) ?>   
                                                        </div>
                
                                                        <div class="col-sm-6 col-xs-12">  
                                                            <?= $form->field($Cashwithdraw, 'bank_branch', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Branch Name', 'class' => 'form-control input-sm txt_bankbranch', 'required' => 'required'])->label(false) ?>     
                                                        </div>
                                                    </div>
                                                </div>    
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12">   
                                                            <?= $form->field($Cashwithdraw, 'swiftcode', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Swift Code', 'class' => 'form-control input-sm txt_swiftcode', 'required' => 'required'])->label(false) ?>    
                                                        </div>  

                                                        <div class="col-sm-6 col-xs-12">  
                                                            <?= $form->field($Cashwithdraw, 'additional_detail', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Additional Details', 'class' => 'form-control input-sm txt_additionaldetail', 'required' => 'required'])->label(false) ?>  
                                                        </div> 
                                                    </div>
                                                </div>    

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12">   
                                                            <?= $form->field($Cashwithdraw, 'amount', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0.01', 'placeholder' => 'BTC Amount', 'class' => 'form-control input-sm amount_withdraw txt_amount', 'required' => 'required'])->label(false) ?>  
                                                            <!-- 'max' => $balance_btc, -->
                                                        </div> 

                                                        <div class="col-sm-6 col-xs-12">
                                                            <div class="fg-line amount_convert_fee">
                                                                <span class="prefix left">Fees : </span><input type="text" disabled=" disabled" class="form-control input-sm amount_convert_fee" id="cashwithdraw-amount_convert"><span class="prefix right currency"></span><p class="help-block help-block-error"></p></div>
                                                        </div>   
                                                    </div>
                                                </div>  

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 col-xs-12">
                                                            <div class="fg-line amount_convert_currency">
                                                                <span class="prefix left">Cash after fees: </span><input type="text" disabled=" disabled" class="form-control input-sm amount_convert" id="cashwithdraw-amount_convert"><span class="prefix right currency"></span><p class="help-block help-block-error"></p></div>
                                                        </div> 
                                                        <div class="col-sm-6 col-xs-12"> 
                                                            <div class="form-group btn-group">  
                                                                <a class="btn btn-gh" id="btnCashwithdrawal"  href="javascript:;">REQUEST TRANSFER</a>     
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div><!--row-->
                                    <?php ActiveForm::end(); ?>
                                </div> <!-- / #btc-cash-draw -->
                            </div><!-- your-cash-box -->
                        </div><!-- col-md-12 -->
                    </div>                   
                   
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->

<div class="bitcoin-wallet-history">    
    <div class="widget">
        <div class="widget-content padding">
            <div class="history-box">
                <h3 class="title-general"><?=Yii::$app->languages->getLanguage()["withdraw_history"]?></h3>
                <div class="" id="with-history">
                        <div class="table-responsive">
                            <table id="datatables-1" class="table table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th data-sortable="false" class="tr-dark">Time</th>
                                        <th data-sortable="false" class="tr-dark">Amount</th>                                                                                                
                                        <th data-sortable="false" class="tr-dark">Status</th>
                                        <th data-sortable="false" class="tr-dark">Confirmations</th>
                                        <th data-sortable="false" class="tr-dark">Details</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php 
                                    $trans_withdraw = 0;
                                    $trans_send1 = 0;
                                    $trans_send2 = 0;
                                    foreach($transction_btc as $transaction) {
                                        // echo '<pre>';
                                        // print_r($transaction);
                                        // echo '</pre>';
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
                                            $trans_withdraw++;
                                            if(!empty($transaction['label'])){ 

                                                if (in_array($transaction['label'], $arrBitcoinWallet)) {
                                                //giao dich voi bitcoin system
                                                }
                                                else{
                                                    $trans_send1++;
                                                ?>
                                        <tr>
                                            <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
                                            <td class="green-number"><?=$transaction['amount']?> BTC</td>                                                
                                            <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url'] ?>images/<?=$img?>"> <?=$status?></td>
                                            <td><?=$transaction['address']?></td>
                                            <td class="view-more-table">
                                                <a href="<?=Yii::$app->params['blockchain_url'].$transaction['txid']?>" title="" target="_blank">View more</a>
                                            </td>
                                        </tr>
                                                <?php 
                                                }

                                            } else {
                                                $trans_send2++;
                                    ?>
                                        <tr>
                                            <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
                                            <td class="green-number"><?=$transaction['amount']?> BTC</td>                                                
                                            <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url'] ?>images/<?=$img?>"> <?=$status?></td>
                                            <td><?=$transaction['address']?></td>
                                            <td class="view-more-table">
                                                <a href="<?=Yii::$app->params['blockchain_url'].$transaction['txid']?>" title="" target="_blank">View more</a>
                                            </td>
                                        </tr>
                                    <?php 
                                            }
                                        }
                                    }   
                                    ?>                            
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- / with-history -->
            </div><!--history-box -->

            <div class="history-box">
                <h3 class="title-general"><?=Yii::$app->languages->getLanguage()["deposit_history"]?></h3>
                <div class="" id="deposit-history">
                        <div class="table-responsive">
                            <table id="datatables-2" class="table table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th data-sortable="false" class="tr-dark">Time</th>
                                        <th data-sortable="false" class="tr-dark">Amount</th>                                                                                                
                                        <th data-sortable="false" class="tr-dark">Status</th>
                                        <th data-sortable="false" class="tr-dark">Actual Amount Received</th>
                                        <th data-sortable="false" class="tr-dark">Details</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php 
                                    $trans_deposit = 0;
                                    foreach($transction_btc as $transaction) {

                                        if (!empty($transaction['blocktime'])){
                                            $class = "color-complete";
                                            $img = "icon-complete.png";
                                            $status = "Complete";
                                        }else{ 
                                            $class = "color-pending";
                                            $img = "icon-pending.png";
                                            $status = "Pending";
                                        }
                                        if($transaction['category']=="receive") { 
                                            $txid = $client->gettransaction($transaction['txid']);
                                            if (in_array($txid['details'][0]['account'], $arrBitcoinWallet)) {
                                                //giao dich voi bitcoin system
                                            } 
                                            else{
                                                $trans_deposit++;
                                    ?>
                                        <tr>
                                            <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
                                            <td class="green-number"><?=$transaction['amount']?> BTC</td>                                                
                                            <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url'] ?>images/<?=$img?>"> <?=$status?></td>
                                            <td><?=$transaction['amount']. ' BTC';?></td>
                                            <td class="view-more-table">
                                                <a href="<?=Yii::$app->params['blockchain_url'].$transaction['txid']?>" title="" target="_blank">View more</a>
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    }   
                                    ?>                                   
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- / deposit-history -->
            </div><!--history-box -->
        </div>
    </div><!-- widget -->
</div><!--token-history-->

<div class="modal fade bs-example-modal-md" id="otp_token" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">BTC Withdrawal - Enter OTP</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <form>
                    <p>OTP code has been sent to your email. Please enter it here.</p>
                    <div class="">
                        <label>OTP Code</label>
                        <input type="text" class="form-control code_otptokentransfer" placeholder="Enter OTP code here">
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


<div class="modal fade bs-example-modal-md" id="success_tokentransfer" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">BTC withdrawal</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <p class="bottom-donate">
                    Your withdrawal was successful
                </p>
                <div class="button-donate">
                    <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>    
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-md" id="otp_cashwithdraw" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Cash withdrawal - Enter OTP</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <form>
                    <p>OTP code has been sent to your email. Please enter it here.</p>
                    <div class="">
                        <label>OTP Code</label>
                        <input type="text" class="form-control code_otpcashwithdraw" placeholder="Enter OTP code here">
                        <p class="otp_code_cashwithdraw_alert"></p>
                    </div>
                    <div class="button-donate">
                        <button type="button" id="submit_otpcode_cashwithdraw" class="btn btn-donate">SUBMIT</button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-md" id="success_cashwithdraw" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Cash withdrawal</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <p class="bottom-donate success_cashwithdraw">
                    Your withdrawal was successful
                </p>
                <div class="button-donate">
                    <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>    
        </div>
    </div>
</div>

<?=$this->registerJs("
    $('#click-to-withdraw').click(function(){
        var x;
        var amount = $('#withdrawbitcoin-amount').val();
        var balance = $('#withdrawbitcoin-balance').val();
        var address = $('#withdrawbitcoin-btcaddress').val();
        var account = '".$user->id."';
        if(hasWhiteSpace(address)){
            $('.field-withdrawbitcoin-btcaddress').addClass('has-error');
            $('.field-withdrawbitcoin-btcaddress .help-block').html('".Yii::$app->languages->getLanguage()['bitcoin_address_contains_illegal_characters_or_space']."');
            return false;
        }
        var v = checkbitcoinaddress(address);

        if(!address){
            $('.field-withdrawbitcoin-btcaddress').addClass('has-error');
            $('.field-withdrawbitcoin-btcaddress .help-block').html('Bitcoin address ".Yii::$app->languages->getLanguage()['cannot_be_blank']."');
            return false;
        } else if (v == false){
            $('.field-withdrawbitcoin-btcaddress').addClass('has-error');
            $('.field-withdrawbitcoin-btcaddress .help-block').html('Bitcoin address ".Yii::$app->languages->getLanguage()['is_invalid']."');
            return false;
        } else{
            $('.field-withdrawbitcoin-btcaddress').removeClass('has-error');
            $('.field-withdrawbitcoin-btcaddress .help-block').html('');
        }
        if(!amount){
            $('.field-withdrawbitcoin-amount ').addClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('Amount ".Yii::$app->languages->getLanguage()['cannot_be_blank']."');
            return false;
        } else if(amount <=0){
            $('.field-withdrawbitcoin-amount ').addClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('Amount entered ".Yii::$app->languages->getLanguage()['is_invalid'].".');
            return false;
        } 
        else if (isNaN(amount)){
            $('.field-withdrawbitcoin-amount ').addClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('Amount entered ".Yii::$app->languages->getLanguage()['is_invalid'].".');
            return false;
        }
        else if ( amount > balance){
            $('.field-withdrawbitcoin-amount ').addClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('".Yii::$app->languages->getLanguage()['your_balance_is_not_enough'].".');
            return false;
        }
        else if ( amount <= balance && amount > balance - 0.0005){
            $('.field-withdrawbitcoin-amount ').addClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('".Yii::$app->languages->getLanguage()['please_enter_a_smaller_amount'].".');
            return false;
        }       
        else{
            $('.field-withdrawbitcoin-amount ').removeClass('has-error');
            $('.field-withdrawbitcoin-amount  .help-block').html('');
        }
        $.ajax({
            dataType: \"html\",
            type: \"POST\", 
            url:'/bitwallet/withdraw', 
            data: {amount : amount, address : address, account : account}, 
            success: function (data) {
                if(data){
                    $('.code_otptokentransfer').attr(\"data\", data);
                    $('#otp_token').modal();
                } else {
                    $('#withdraw_alert').css('display', 'block');
                    $('#withdraw_alert').html('<i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>Process failed');
                } 
            }
        });
    });
")?>

<?=$this->registerJs("
    $('#submit_otpcode').click(function(){
        var otp_code = $('.code_otptokentransfer').val();
        var id_withdraw = $('.code_otptokentransfer').attr('data');
        if(!otp_code){
            $('.otp_code_alert').html('<p class=\"text-red\">Please enter OTP code!</p>')
            $('.code_otptokentransfer').focus();
            return false;
        } else {
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/bitwallet/confirm_otpcode', 
                data: {id_withdraw : id_withdraw, otp_code : otp_code}, 
                success: function (data) {
                    if(data){
                        $('#otp_token').hide();
                        $('#success_tokentransfer').modal();
                    } else {
                        $('.otp_code_alert').html('<p class=\"text-red\">OTP code incorrect!</p>')
                        $('.code_otptokentransfer').focus();
                        return false;
                    }
                }
            });
        }
    })
")?>


<?=$this->registerJs("
    $('#select-country').change(function(){
        var country = $(this).val();
        $.ajax({
            type: \"POST\", 
            url:'/bitwallet/selectcountry', 
            data: {country : country}, 
            success: function (data) {
                $('.list_address').html(data);
            }
        });
    })
")?>

<?=$this->registerJs("
    $('.select_currency').change(function(){
        var country = $(this).val();

        if(country == 3){
            $('.txt_swiftcode').val('vn');
            $('.txt_additionaldetail').val('vn');
            $('.field-cashwithdraw-swiftcode').css('display', 'none');
            $('.field-cashwithdraw-additional_detail').css('display', 'none');
        } else {
            $('.txt_swiftcode').val('');
            $('.txt_additionaldetail').val('');
            $('.field-cashwithdraw-swiftcode').css('display', 'block');
            $('.field-cashwithdraw-additional_detail').css('display', 'block');
        }
        $.ajax({
            type: \"POST\", 
            url:'/bitwallet/selectcurrency', 
            data: {country : country}, 
            success: function (data) {
               // $('.getcurrency').val(data);
                $('.amount_convert_currency .currency').html(data);
                $('.amount_convert_fee .currency').html(data);
            }
        });
    })
")?>

<?=$this->registerJs("
    $('.amount_withdraw').keyup(function(){
        var amount = $(this).val();
        var currency = $('.select_currency').val();
        $.ajax({
            type: \"POST\", 
            url:'/bitwallet/getamountwithdrawconvert', 
            data: {amount : amount, currency : currency}, 
            success: function (data) {
                $('.amount_convert').val(formatMoney(data[0], \"\"));
                $('.amount_convert_fee').val(formatMoney(data[1], \"\"));
            }
        });
    })
")?>

<?=$this->registerJs("
    $('#btnCashwithdrawal').click(function(){

        var txt_balance       = ".$balance_btc.";
        var txt_country       = $('.txt_country').val();
        var txt_bankname      = $('.txt_bankname').val();
        var txt_recepientname = $('.txt_recepientname').val();
        var txt_bankaccount   = $('.txt_bankaccount').val();
        var txt_bankbranch    = $('.txt_bankbranch').val();
        var txt_swiftcode     = $('.txt_swiftcode').val();
        var txt_additionaldetail = $('.txt_additionaldetail').val();
        var txt_amount        = $('.txt_amount').val();

        if(!txt_country){
            $('.txt_country').focus();
            return false;
        }
        if(!txt_bankname){
            $('.txt_bankname').focus();
            return false;
        }
        if(!txt_recepientname){
            $('.txt_recepientname').focus();
            return false;
        }
        if(!txt_bankaccount){
            $('.txt_bankaccount').focus();
            return false;
        }
        if(!txt_bankbranch){
            $('.txt_bankbranch').focus();
            return false;
        }
        if(!txt_swiftcode){
            $('.txt_swiftcode').focus();
            return false;
        }
        if(!txt_additionaldetail){
            $('.txt_additionaldetail').focus();
            return false;
        }
        if(!txt_amount){
            $('.txt_amount').focus();
            return false;
        }
        if(txt_amount > txt_balance){
            $('.field-cashwithdraw-amount').addClass('has-error');
            $('.field-cashwithdraw-amount .help-block').html('Your balance is not enough.');
            return false;
        }
        if(txt_amount <= txt_balance && txt_amount > txt_balance - 0.0005){
            $('.field-cashwithdraw-amount').addClass('has-error');
            $('.field-cashwithdraw-amount .help-block').html('Please enter a smaller amount.');
            return false;
        }

        $.ajax({
            type: \"POST\", 
            url:'/bitwallet/cashwithdraw', 
            data: {txt_country : txt_country, txt_bankname : txt_bankname, txt_recepientname : txt_recepientname, txt_bankaccount : txt_bankaccount, txt_bankbranch : txt_bankbranch, txt_swiftcode : txt_swiftcode, txt_additionaldetail : txt_additionaldetail, txt_amount : txt_amount}, 
            success: function (data) {
                if(data){
                    $('.code_otpcashwithdraw').attr(\"data\", data);
                    $('#otp_cashwithdraw').modal();
                } else {
                    $('#cashwithdraw_alert').css('display', 'block');
                    $('#cashwithdraw_alert').html('<i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>Process failed');
                } 
            }
        });
    })
")?>

<?=$this->registerJs("
    $('#submit_otpcode_cashwithdraw').click(function(){
        var otp_code = $('.code_otpcashwithdraw').val();
        var id_withdraw = $('.code_otpcashwithdraw').attr('data');
        if(!otp_code){
            $('.otp_code_cashwithdraw_alert').html('<p class=\"text-red\">Please enter OTP code!</p>')
            $('.code_otpcashwithdraw').focus();
            return false;
        } else {
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/bitwallet/confirm_otpcode_cashwithdraw', 
                data: {id_withdraw : id_withdraw, otp_code : otp_code}, 
                success: function (data) {
                    if(data){
                        $('#otp_cashwithdraw').hide();
                        $('.success_cashwithdraw').html(data);
                        $('#success_cashwithdraw').modal();
                    } else {
                        $('.otp_code_cashwithdraw_alert').html('<p class=\"text-red\">OTP code incorrect!</p>')
                        $('.code_otpcashwithdraw').focus();
                        return false;
                    }
                }
            });
        }
    })
")?>

<?php
if($trans_withdraw > 10){
    echo $this->registerJs("
        $('#datatables-1').dataTable();
    ");
}
if($trans_deposit > 10){
    echo $this->registerJs("
        $('#datatables-2').dataTable();
    ");
}
?>

