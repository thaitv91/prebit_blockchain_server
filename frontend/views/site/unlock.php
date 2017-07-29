<?php 
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>BITCOIN WALLET</h2>
         You can check all information regarding your PreBit wallet here
    </div>                    
</div>

<div class="row token-history token-manager">
    <div class="col-md-12">
        <div class="bg-white">
            <div class="title-token-history">
                <h3>Manage Bitcoin Wallet</h3>
                <p>Use your PreBit wallet to buy Tokens, Send Help, send and receive BTC</p>
            </div>
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

                    <ul id="bicoin-wallet-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#info" data-toggle="tab">INFO</a>
                        </li>
                        <li class="">
                            <a href="#btc-width-draw" data-toggle="tab">BTC WITHDRAW</a>
                        </li>
                        <li class="">
                            <a href="#btc-cash-draw" data-toggle="tab">CASH WITHDRAW</a>
                        </li>
                        <li class="">
                            <a href="#buy-btc" data-toggle="tab">BUY BTC</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <input id="withdrawbitcoin-balance" type="hidden" value="<?=$balance_btc?>">
                        <div class="tab-pane fade active in" id="info">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 col-lg-offset-1">
                                <img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=?=$address_btc[0]?>" alt="QR Code" class="img-responsive">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                                <h5 class="title-i">Blockchain Wallet Balance</h5>
                                <h3 class="green-number"><?=number_format($balance_btc, 8);?> BTC</h3>
                                <p>Wallet Address</p>
                                <form class="form-inline">
                                    <div class="form-group has-feedback">
                                        <div class="input-group">                                                            
                                            <div class="form-control" id="inputGroupSuccess3" aria-describedby="inputGroupSuccess3Status"><?=$address_btc[0]?></div>
                                            <span class="input-group-addon"><img src="<?= Yii::$app->params['site_url'] ?>images/icon-wallet-address.png"></span>
                                        </div>
                                    </div>
                                </form>
                                <div class="wallet-text">
                                    Above is the address of your PreBit wallet, the equivalent QR code of this wallet is also provided. You will need to deposit BTC into this PreBit wallet to buy Tokens and Send Help. You will also need to use this PreBit wallet to withdraw your BTC to your external Bitcoin wallets hosted somewhere else. 
                                </div>
                            </div>
                        </div> <!-- / .tab-pane -->
                        <div class="tab-pane fade" id="btc-width-draw">
                            <?php $form = ActiveForm::begin(['id' => 'WithdrawBitcoin']); ?>
                                <h5 class="title-i">BTC Withdrawal</h5>
                                <p>You are eligible to withdraw 0 BTC</p>
                                <div id="withdraw_alert" class="alert-system alert alert-success col-md-12">
                                    
                                </div>
                                <div class="row paddtop10">
                                    <div id="form-hide-request">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($WithdrawBitcoin, 'btcaddress', ['template' => '<div class="pos-re">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'External Wallet Address', 'class' => 'form-control input-sm btcaddress', 'required' => 'required'])->label(false) ?>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($WithdrawBitcoin, 'amount', ['template' => '<div class="fg-line">{input}<span class="prefix right">BTC</span> {hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Withdrawal Amount', 'class' => 'form-control input-sm amount', 'required' => 'required'])->label(false) ?>        
                                        </div>                                   
                                        <a id="click-to-withdraw" class="btn btn btn btn-warning">REQUEST TRANSFER</a>
                                    </div>
                                    <div id="form-show-request">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group ">
                                                <div class="fg-line">
                                                    <input type="text" class="form-control input-sm" placeholder="External Wallet Address">
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                                            <div class="form-group">
                                                <div class="fg-line">
                                                    <input type="number" name="amount" placeholder="Withdrawal Amount" class="form-control input-sm"><span class="prefix right">BTC</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">    
                                            <div class="form-group">
                                                <div class="fg-line">
                                                    <input type="text" class="form-control input-sm" placeholder="OTP Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">    
                                            <div class="form-group">
                                                <a href="#" class="btn btn btn btn-success">PROCEED TRANSFER</a>
                                            </div>
                                        </div>    
                                    </div><!--form-show-request-->
                                </div><!--row-->
                            <?php ActiveForm::end(); ?>
                        </div> <!-- / .tab-pane -->
                        <div class="tab-pane fade" id="btc-cash-draw">
                            <?php $form = ActiveForm::begin(['id' => 'Cashwithdraw']); ?>
                                
                                <h5 class="title-i">Cash Withdrawal</h5>
                                <p>Use this form below to withdraw cash to your bank account</p>
                                <div class="row paddtop10">
                                    <div id="form-cash-draw">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 col-xs-12">
                                                <?= $form->field($Cashwithdraw, 'currency', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->dropDownList($Cashwithdraw->listCurrency, ['class' => 'form-control select_country'])->label(FALSE); ?>
                                                </div>

                                                <div class="col-sm-6 col-xs-12">
                                                    <?= $form->field($Cashwithdraw, 'getcurrency', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Currency', 'class' => 'form-control input-sm getcurrency', ' disabled' => ' disabled'])->label(false) ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 col-xs-12">
                                                    <?= $form->field($Cashwithdraw, 'bank_name', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Name', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>
                                                </div>
                                                
                                                <div class="col-sm-6 col-xs-12">   
                                                    <?= $form->field($Cashwithdraw, 'recepient_name', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Recepient Name', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 col-xs-12"> 
                                                    <?= $form->field($Cashwithdraw, 'bank_account', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Account Number', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>   
                                                </div>
        
                                                <div class="col-sm-6 col-xs-12">  
                                                    <?= $form->field($Cashwithdraw, 'bank_branch', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Bank Branch Name', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>     
                                                </div>
                                            </div>
                                        </div>    
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 col-xs-12">   
                                                    <?= $form->field($Cashwithdraw, 'swiftcode', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Swift Code', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>    
                                                </div>  

                                                <div class="col-sm-6 col-xs-12">  
                                                    <?= $form->field($Cashwithdraw, 'additional_detail', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Additional Details', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>  
                                                </div> 
                                            </div>
                                        </div>    

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 col-xs-12">   
                                                    <?= $form->field($Cashwithdraw, 'amount', ['template' => '<div class="fg-line">{input}{hint}{error}</div>'])->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0.01', 'placeholder' => 'BTC Amount', 'class' => 'form-control input-sm', 'required' => 'required'])->label(false) ?>  
                                                </div>   
                                                <div class="col-sm-6 col-xs-12"> 
                                                    <div class="form-group">  
                                                        <?= Html::submitButton('REQUEST TRANSFER', ['class' => 'btn btn btn btn-warning']) ?>    
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>    
                                    </div>
                                </div><!--row-->
                            <?php ActiveForm::end(); ?>
                        </div> <!-- / .tab-pane -->
                        <div class="tab-pane fade" id="buy-btc">
                            <h5 class="title-i">Buy BTC</h5>
                            <p>Find where to buy BTC in your country</p>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <label>Choose Country:</label>
                                            <select class="form-control" id="select-country">
                                                <option style="background-image:url(<?= Yii::$app->params['site_url'] ?>images/flag-vn.png);"> Viet Nam</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <h5 class="title-i">Buy BTC Address:</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="http://bitkingdom.org" title="">http://bitkingdom.org</a></li>
                                        <li><a href="www.coindesk.com" title="">www.coindesk.com</a></li>
                                        <li><a href="https://www.weusecoins.com" title="">https://www.weusecoins.com</a></li>
                                        <li><a href="https://bitcoin.org" title="">https://bitcoin.org</a></li>
                                    </ul>
                                </div>
                            </div><!--row-->                                                
                        </div> <!-- / .tab-pane -->
                    </div> <!-- / .tab-content -->
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->

<div class="row bitcoin-wallet-history">
    <div class="widget-content padding">
        <ul id="history-wallet" class="nav nav-tabs">
            <li class="active">
                <a href="#with-history" data-toggle="tab">WITHDRAWAL HISTORY</a>
            </li>
            <li class="">
                <a href="#deposit-history" data-toggle="tab">DEPOSIT HISTORY</a>
            </li>                            
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="with-history">
                <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr class="tr-green">
                                <th data-sortable="false">Time</th>
                                <th data-sortable="false">Amount</th>                                                                                                
                                <th data-sortable="false">Status</th>
                                <th data-sortable="false">Confirmations</th>
                                <th data-sortable="false">Details</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
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
                                if($transaction['category']=="send") { 
                                    if (in_array($transaction['label'], $arrBitcoinWallet)) {
                                        //giao dich voi bitcoin system
                                    }
                                    else{
                            ?>
                                <tr>
                                    <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
                                    <td class="green-number"><strong><?=$transaction['amount']?> BTC</strong></td>                                                
                                    <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url'] ?>images/<?=$img?>"><?=$status?></td>
                                    <td><?=$transaction['address']?></td>
                                    <td class="view-more-table">
                                        <i class="fa fa-chevron-circle-right"></i> 
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
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="deposit-history">
                <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr class="tr-green">
                                <th data-sortable="false">Time</th>
                                <th data-sortable="false">Amount</th>                                                                                                
                                <th data-sortable="false">Status</th>
                                <th data-sortable="false">Confirmations</th>
                                <th data-sortable="false">Details</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
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
                            ?>
                                <tr>
                                    <td><?=date('d/m/Y - H:i:s', $transaction['time'])?></td>
                                    <td class="green-number"><strong><?=$transaction['amount']?> BTC</strong></td>                                                
                                    <td class="<?=$class?>"><img src="<?= Yii::$app->params['site_url'] ?>images/<?=$img?>"><?=$status?></td>
                                    <td><?=$transaction['address']?></td>
                                    <td class="view-more-table">
                                        <i class="fa fa-chevron-circle-right"></i> 
                                        <a href="<?=Yii::$app->params['blockchain_url'].$transaction['txid']?>" title="" target="_blank">View more</a>
                                    </td>
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
</div><!--token-history-->

