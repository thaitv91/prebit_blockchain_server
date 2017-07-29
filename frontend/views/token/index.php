<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\TokenRequest;

$this->title = 'Fee - PreBit';
$bitcoinfortoken = file_get_contents('https://blockchain.info/tobtc?currency=USD&value='.$bitpertoken);
?>


<div class="token-history token-manager">
    <div class="">
        <div class="bg-white">
            <div class="title-token-history">
                <h3 class="title-general">Your Fee Balance: <?=Yii::$app->user->identity->token;?></h3>
            </div>
            <?php if(Yii::$app->session->hasFlash('alert_token')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <?= Yii::$app->session->getFlash('alert_token') ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-dark-gray token-box">
                        <div class="row header-box">
                            <div class="col-md-4 col-sm-5">
                                <h3>Purchase fee</h3>
                            </div>
                            <div class="col-md-8 col-sm-7 text-right hidden-xs">
                                <h4>Buy Fee at <?=$bitcoinfortoken?> BTC / Fee</h4>
                                <p><?=Yii::$app->languages->getLanguage()['this_price_is_automatically_converted_based_on_the_current_btc_rate']?>.</p>
                            </div>
                        </div>
                        
                        <div class="" id="buy-token">
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-inline']]); ?>
                                <?= $form->field($model, 'bitcoin')->textInput(['class'=>'tokenrequest_bitcoin' ,'type'=>'hidden', 'value'=>''])->label(false) ?>
                                
                                 <div class="radio">
                                    <label>Buy Fee using:</label>
                                    <select class="form-control" name="optionsRadios" id="optionsRadios1">
                                        <option>Buy Fee using Bitcoin Wallet - Available Balance: <?=$balance?> BTC</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <?= $form->field($model, 'amount', ['template'=>'<label for="token-amount" class="col-sm-12 col-lg-6 control-label">Fee amount:</label><div class="pad0mobi">{input}{hint}{error}</div>'])->textInput(['class'=>'bit-number form-control', 'required'=>'required', 'type'=>'number'])->label(false) ?>
                                        <input type="hidden" id="bitpertoken" value="<?=$bitcoinfortoken?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <fieldset disabled>
                                            <div class="form-group payment-amount">
                                                <label for="disabledTextInput" class="col-sm-12 col-lg-6"><?=Yii::$app->languages->getLanguage()['payment_amount']?>:</label>
                                                <div class="pad0mobi">
                                                    <input type="text" id="disabledTextInput" class="form-control amount-disable" placeholder="0 BTC">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="pull-left pad0mobi">
                                    <a class="btn btn-transpa btn-cancel">Requires <b><span id="tokenforgh1">0</span></b> POINT(s)</a>
                                </div><!-- /.pad0mobi -->

                                <div class="clearfix text-right visible-xs">
                                    <h4>Buy Fee at <?=$bitcoinfortoken?> BTC / Fee</h4>
                                    <p><?=Yii::$app->languages->getLanguage()['this_price_is_automatically_converted_based_on_the_current_btc_rate']?>.</p>
                                </div>

                                <div class="pull-right btn-group">
                                    <button class="btn btn-comfirm " type="submit" name="buyToken">CONFIRM PAYMENT</button>
                                    <button class="btn btn-reset">RESET</button>
                                </div><!-- /.btn-group -->
                            <?php ActiveForm::end(); ?>
                        </div><!-- buy-token -->
                    </div><!-- bg-dark-gray -->
                </div><!-- col-md-6 -->

                <div class="col-md-6">
                    <div class="bg-dark-gray token-box">
                        <div class="row header-box">
                            <div class="col-md-4 col-sm-5">
                                <h3>Transfer fee</h3>
                            </div>
                            <div class="col-md-8 col-sm-7 text-right xs">
                                <h4>    </h4>
                                <p>You can transfer Fees to your friends using the form below.</p>
                            </div>
                        </div>
   
                        <div class="" id="transfer-token">
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-inline', 'id' => 'transfertoken']]); ?>  
                                
                                
                                <?php 
                                if($token_cantransfer <= 0){
                                    echo Yii::$app->languages->getLanguage()['you_cannot_transfer_tokens_at_this_time'];
                                }else{
                                ?>

                                <div class="form-group padleft0">
                                    <?= $form->field($TransferToken, 'reciever',['template' => '<label for="transfer-to">Transfer to: </label> {input}{hint}{error}'])->textInput(['class'=>'bit-number form-control tokenrequest_reciever', 'required'=>'required', 'type'=>'text', 'value'=>''])->label(false) ?>
                                </div>
                                <div class="form-group pad0mobi">
                                    <?= $form->field($TransferToken, 'amount_token', ['template' => '<label for="token-amount">Fee amount: </label> {input}{hint}{error}'])->textInput(['class'=>'bit-number form-control tokenrequest_amounttoken', 'required'=>'required', 'type'=>'number', 'min'=>'1', 'max'=>$token_cantransfer])->label(false) ?>
                                </div>
                                

                                <div class="pull-right btn-group">
                                    <a href="javascript:;" class="btn btn-gh transfer-subbmit">CONFIRM TRANSFER</a>
                                </div><!-- /.btn-group -->
                                <?php }?>
                            <?php ActiveForm::end(); ?>
                        </div> <!-- / transfer-token -->
                    </div><!-- bg-dark-gray -->
                </div><!-- col-md-6 -->
            </div>

    </div>
</div><!--token-history-->
<div class="token-history">
    <div class="">
        <div class="bg-white">
            <div class="title-token-history">
                <h3 class="title-general">Fee transaction history</h3>
            </div>
            <div class="widget">
                <div class="widget-content">                    
                    <div class="table-responsive">
                        <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'attribute' => '',
                                'label' => 'Time',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left tr-dark'],
                                'value' => function($data){
                                    return date('d/m/Y H:i', $data->created_at);
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Amount',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left tr-dark'],
                                'value' => function($data){
                                    if($data->mode == TokenRequest::MODE_BUY){
                                        $amount = '<span class="amount-green">+'.$data->amount.'</span>';
                                    }
                                    if($data->mode == TokenRequest::MODE_TRANS){
                                        if($data->user_id == Yii::$app->user->identity->id){
                                            $amount = '<span class="amount-red">-'.$data->amount.'</span>';
                                        }
                                        if($data->reciever == Yii::$app->user->identity->id){
                                            $amount = '<span class="amount-green">+'.$data->amount.'</span>';
                                        }
                                    }
                                    if( ($data->mode == TokenRequest::MODE_SH) || ($data->mode == TokenRequest::MODE_GH) ){
                                        $amount = '<span class="amount-red">-'.$data->amount.'</span>';
                                    }
                                    return $amount;
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Balance',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left tr-dark'],
                                'value' => function($data) {
                                    if($data->reciever == Yii::$app->user->identity->id){
                                        return '-';
                                    } else {
                                        return '<b>'.$data->balance.'</b>';
                                    }
                                    
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Description',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-left tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    if($data->mode == TokenRequest::MODE_BUY){
                                        $status = 'Purchased '.$data->amount.' fee(s)';
                                    }
                                    if($data->mode == TokenRequest::MODE_TRANS){
                                        if($data->user_id == Yii::$app->user->identity->id){
                                            if ($data->getUser($data->reciever)) {
                                                $status = 'Transfered '.$data->amount.' fee(s) to '.$data->getUser($data->reciever)->username;
                                            } else {
                                                $status = 'Transfered '.$data->amount.' fee(s)';
                                            }
                                        }
                                        if($data->reciever == Yii::$app->user->identity->id){
                                            $status = 'Received '.$data->amount.' fee(s) from '.$data->getUser($data->user_id)->username;
                                        }
                                        
                                    }
                                    if( $data->mode == TokenRequest::MODE_GH ){
                                        $status = 'Used '.$data->amount.' Fee(s) for GH';
                                    }
                                    if( $data->mode == TokenRequest::MODE_SH ){
                                        $status = 'Used '.$data->amount.' Fee(s) for SH';
                                    }
                                    return $status;
                                }
                            ],
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table'],
                    ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->

<div class="modal fade bs-example-modal-md" id="otp_token" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">OTP code for Fee transfer</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <form>
                    <div class="">
                        <label>OTP code</label>
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
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Fee transfer</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <p class="bottom-donate">
                    Token transfer was successful
                </p>
                <div class="button-donate">
                    <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>    
        </div>
    </div>
</div>




<?=$this->registerJs("
    $('.bit-number').keyup(function(){
        var bitpertoken = ".$bitcoinfortoken.";
        var value = $(this).val();
        var bitcoin = bitpertoken*value;
        var num = bitcoin.toFixed(8);
        $('#disabledTextInput').val(num+' BTC');
        $('#tokenrequest-bitcoin').val(num);
    })
")?>

<?=$this->registerJs("
    $('.transfer-subbmit').click(function(){
        //$('#otp_token').modal();
        var reciever = $('.tokenrequest_reciever').val();
        var amounttoken = $('.tokenrequest_amounttoken').val();
        var tokenuser = ".$token_cantransfer.";
        var user = ".Yii::$app->user->identity->id.";
        if(!reciever){
            $('.field-transfertoken-reciever .help-block').html('<p class=\"text-red\">".Yii::$app->languages->getLanguage()['reciever_username_connot_be_empty']."</p>');
            $('.field-transfertoken-reciever input').focus();
            return false;
        } else {
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/token/checkissetusername', 
                data: {reciever : reciever}, 
                success: function (data) {
                    if(data){
                        $('.field-transfertoken-reciever .help-block').html('<p class=\"text-red\">".Yii::$app->languages->getLanguage()['this_username_not_exist_in_the_system']."</p>');
                        $('.field-transfertoken-reciever input').focus();
                        return false;
                    } else {
                        $('.field-transfertoken-reciever .help-block').html('');
                    }
                }
            });
        }
        if(!amounttoken){
            $('.field-transfertoken-amount_token .help-block').html('<p class=\"text-red\">".Yii::$app->languages->getLanguage()['token_amount_cannot_be_empty']."</p>');
            $('.field-transfertoken-amount_token input').focus();
            return false;
        } else if ( amounttoken <= 0 ){
            $('.field-transfertoken-amount_token .help-block').html('<p class=\"text-red\">".Yii::$app->languages->getLanguage()['token_amount_must_be_greater_than_0']."</p>');
            $('.field-transfertoken-amount_token input').focus();
            return false;
        }else if (amounttoken > tokenuser){
            $('.field-transfertoken-amount_token .help-block').html('<p class=\"text-red\">".Yii::$app->languages->getLanguage()['please_enter_a_smaller_token_amount']."</p>');
            $('.field-transfertoken-amount_token input').focus();
            return false;
        } else{
            $('.field-transfertoken-amount_token .help-block').html('');
        }

        $.ajax({
            dataType: \"html\",
            type: \"POST\", 
            url:'/token/inserttokentransfer', 
            data: {reciever : reciever, amounttoken : amounttoken, user : user}, 
            success: function (data) {
                if(data){
                    $('.code_otptokentransfer').attr(\"data\", data);
                    $('#otp_token').modal();
                }
            }
        });
    })
")?>


<?=$this->registerJs("
    $('#submit_otpcode').click(function(){
        var otp_code = $('.code_otptokentransfer').val();
        var id_tokenrequest = $('.code_otptokentransfer').attr('data');
        if(!otp_code){
            $('.otp_code_alert').html('<p class=\"text-red\">Please enter OTP code!</p>')
            $('.code_otptokentransfer').focus();
            return false;
        } else {
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/token/confirm_otpcode', 
                data: {id_tokenrequest : id_tokenrequest, otp_code : otp_code}, 
                success: function (data) {
                    if(data){
                        $('.otp_code_alert').html('<p class=\"text-red\">OTP code incorrect!</p>')
                        $('.code_otptokentransfer').focus();
                        return false;
                    } else {
                        $('#otp_token').hide();
                        $('#success_tokentransfer').modal();
                    }
                }
            });
        }
    })
")?>


