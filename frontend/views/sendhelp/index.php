<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use common\models\ShTransfer;

$this->title = 'Deposit - PreBit';
?>


<div class="add-new-sh">  
    <div class="top-dashboard">
        <h2 class="title-general">Deposit</h2>
    </div>          
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="btc-days-row">
                <?php 
                foreach ($active_sh as $key => $value) { 
                    $minday = ($value->min_days * 86400) + $value->created_at;
                    $maxday = ($value->max_days * 86400) + $value->created_at;
                    $remaining_time =  $minday - time();
                    $capital_time = $maxday - time();
                    $datediff = time() - $value->created_at;
                    //$profit_packet = $value->getProfitdaily($value->id);
                    $profit_packet = $value->getProfitdailyUserlevel($value->id);
                    $daily_profit = $value->amount * $profit_packet / 100 / 86400;
                    $amount_profit = (time()- $value->inc_days) * $daily_profit;
                    $sh_withdraw = $value->getShwithdraw($value->id); 
                ?>
                <div class="">
                    <div class="btc-days">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="title-btc">
                                    <div class="row">
                                        <div class="col-xs-8 col-sm-12">
                                            <div class="sh-left">
                                                <h1><?=$value->amount?> BTC</h1>
                                                <!--<p>ID: <?=Yii::$app->params['prefix_id'] + $value->id?></p>-->
                                            </div><!-- /.sh-left -->
                                            <div class="sh-right">
                                                <p class="start-normal">Start Date: <?=date('d-m-Y', $value->created_at)?></p>

                                            </div><!-- /.sh-right -->

                                            <div class="mobile-float">
                                                <b>Deposit Distributed</b>
                                                <?php if(!empty($sh_withdraw)){?>
                                                <p>Last profit withdrawal on <?=date('H:i d-m-Y', ($value->inc_days))?></p>
                                                <?php }?>
                                            </div><!-- /.mobile-float -->
                                        </div>

                                        <div class="col-xs-4 col-sm-12">
                                            <div class="bol-circle">
                                                <h1><?=floor($datediff/(60*60*24));?></h1>
                                                <p><?php if(floor($datediff/(60*60*24)) > 1){ echo 'DAYS';} else { echo 'DAY';}?></p>
                                            </div><!-- /.bol-circle -->
                                        </div>
                                    </div>
                                </div><!--title-btc-->
                            </div><!-- /.col-md-6 -->

                            <div class="col-sm-6">
                                <div class="withdraw">
                                        <div class="pull-right2">
                                            <p><?=Yii::$app->languages->getLanguage()['withdrawable_profit']?></p>
                                            <h4 id="Withdrawable_profit_<?=$key?>" class="green-with"><?=number_format($amount_profit, 8)?></h4>
                                            
                                        </div>
                                    </div><!--withdraw-->
                                    <div class="withdraw">
                                        <div class="pull-right2">
                                            <p><?=Yii::$app->languages->getLanguage()['total_withdraw_profit']?></p>
                                            <h4 id="Total_profit_<?=$key?>" class="green-with"><?=number_format($value->gettotalprofit($value->id), 8);?></h4>
                                            
                                        </div>
                                    </div><!--withdraw-->

                                    <div class="bottom-withdraw hidden-xs">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <a href="javascript:;" title="" data="<?=$value->id;?>" val="<?=Yii::$app->user->identity->id?>" class="Withdraw_profit btn btn-success btn-bit"><?=Yii::$app->languages->getLanguage()['withdraw_profit']?></a>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php 
                                                if($minday > time()){
                                                    echo '<span class="btn btn-primary btn-bit">Withdraw Profit <br>+ Capital</span>';
                                                }else{
                                                    echo '<a href="javascript:;" data="'.$value->id.'" val="'.Yii::$app->user->identity->id.'" class="Withdraw_capital btn btn-primary btn-bit">Withdraw Profit <br>+ Capital</a>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div><!-- /.bottom-withdraw -->
                            </div><!-- /.col-md-6 -->
                        </div>
                        
                        <div class="content-btc">
                           <div class="send-bottom bottom-btc">
                                <div class="pull-right view-more-btc">
                                    <?php if(!empty($sh_withdraw)){?>
                                    <i class="fa fa-arrow-circle-right"></i> 
                                    <a role="button" data-toggle="collapse" href="#shWithdraw_<?=$value->id?>" aria-expanded="false" aria-controls="collapseExample"><?=Yii::$app->languages->getLanguage()['view_more']?></a>
                                    <?php }?>
                                </div>
                                <div class="clear-fix"></div>
                            </div><!--bottom-btc-->
                        </div><!--content-btc-->
                        
                    </div><!--btc-days-->
                    <div class="clear-fix"></div>
                    <?php if(!empty($sh_withdraw)){?>
                    <!-- sh withdraw history -->
                    <div class="collapse shWithdraw" id="shWithdraw_<?=$value->id?>">
                        <div class="well">
                            <table class="table table-condensed"> 
                                <thead> 
                                    <tr> 
                                        <th><?=Yii::$app->languages->getLanguage()['profit_withdrawal_time']?></th> 
                                        <th>Amount</th>
                                    </tr> 
                                </thead> 
                                <tbody>
                                <?php
                                foreach ($sh_withdraw as $val) {
                                    echo '<tr><td>'.date('H:i d-m-Y', $val->created_at).'</td><td>'.number_format($val->amount, 8).'</td><tr> ';
                                }
                                ?> 
                                    
                                </tbody> 
                            </table>
                            <div class="clear-fix"></div>
                        </div>
                        <div class="clear-fix"></div>
                    </div>
                    <!-- End sh withdraw history -->
                    <?php }?>
                </div><!--col-lg-6--> 
                <?php } ?>
            </div><!--btc-days-row-->
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="bg-dark-gray">
                <div class="title-bar-add-new-sh">
                    <h3>Deposit</h3>
                    <p>Mininum Deposit amount is 0.1 BTC</p>
                </div>
                <div class="">
                    <div class="content-add-new-sh">
                        <?php $form = ActiveForm::begin(['id' => 'shtransfer-form']); ?>
                            <?php if(Yii::$app->session->hasFlash('error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    <?= Yii::$app->session->getFlash('error') ?>
                                </div>
                            <?php endif; ?>
                            <?php if(Yii::$app->session->hasFlash('success')): ?>
                                <div class="alert alert-success" role="alert">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <?= Yii::$app->session->getFlash('success') ?>
                                </div>
                            <?php endif; ?>
                            <?= $form->field($sendhelpTransfer, 'amount', ['template' => '<div class="pos-re">{input}<span class="form-control-feedback" aria-hidden="true">BTC</span>{hint}{error}</div>'])->textInput(['type' => 'number', 'placeholder' => 'Amount', 'class' => 'form-control', 'step' => '0.01'])->label(false) ?>
                            
                            <div class="pull-left pad0mobi">
                                <a class="btn btn-reset">Requires <b><span id="tokenforthissendhelp">0</span></b> Fee</a>
                            </div>
                            <div class="pull-right btn-group">
                                <button class="btn btn-gh" data-confirm="Are you sure you want to Sending?">Deposit</button>
                                <button type="reset" class="btn btn-reset"><?=Yii::$app->languages->getLanguage()['btn_cancel']?></button>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div><!--add-new-sh-->      


<div class="row end-send-help">
    <div class="col-md-12">
        <h3 class="title-end-send-help title-general no-margin-bottom-xs">END DEPOSIT LIST</h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "<div class='col-md-12'>{pager}</div>\n{items}\n<div class='col-md-12'>{summary}</div>\n<div class='col-md-12'>{pager}</div>",
                        'columns' => [
                            [
                                'label' => 'ID',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    return  Yii::$app->params['prefix_id'] + $data->id;
                                }
                            ],
                            [
                                'label' => 'Start Date',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return date('d/m/Y H:i',$data->created_at);
                                }
                            ],
                            [
                                'label' => 'End Date',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return date('d/m/Y H:i',$data->inc_days);
                                }
                            ],
                            [
                                'label' => 'Capital',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                return  $data->amount.' BTC';
                                }
                            ],
                            [
                                'label' => 'Profit',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return  number_format($data->getProfit($data->id), 8).' BTC';
                                }
                            ],
                            [
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    if($data->status == ShTransfer::STATUS_HOLD){
                                        $status = '<span class="color-pending"><img src="'.Yii::$app->params['site_url'].'images/icon-pending.png"> Pending</span>';
                                    }
                                    if($data->status == ShTransfer::STATUS_WITHDRAW){
                                        $status = '<span class="color-pending"><img src="'.Yii::$app->params['site_url'].'images/icon-pending.png"> Pending</span>';
                                    }
                                    if($data->status == ShTransfer::STATUS_CAPITAL_WITHDRAW){
                                        $status = '<span class="color-pending"><img src="'.Yii::$app->params['site_url'].'images/icon-pending.png"> Pending</span>';
                                    }
                                    if($data->status == ShTransfer::STATUS_COMPLETED){
                                        $status = '<span class="color-complete"><img src="'.Yii::$app->params['site_url'].'images/icon-complete.png"> Complete</span>';
                                    }
                                    return  $status;
                                }
                            ],
                            
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table'],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div><!--end-send-help-->


<div id="withdraw_modal" class="modal fade bs-example-modal-sm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Withdraw success</h4>
            </div>
            <div class="modal-body ">
                <p class="withdraw_alert_p">One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<?php
foreach ($active_sh as $key => $value) { 
    //$profit_packet = $value->getProfitdaily($value->id);
    $profit_packet = $value->getProfitdailyUserlevel($value->id);
    $daily_profit = $value->amount * $profit_packet / 100 / 86400;
    $daily_profits = $value->amount * $profit_packet / 100 / 864000;
    $amount_profit = (time()- $value->inc_days) * $daily_profit;
?>
<?= $this->registerJs("
    $('#Withdrawable_profit_'+".$key.").increment({coef: ".number_format($daily_profits, 8).", speed:100, amount: ".number_format($amount_profit, 8)."});
") ?>
<?php }?>

<?=$this->registerJs("
$('.Withdraw_profit').click(function(){
    var id_sh = $(this).attr('data')
    var id_user = $(this).attr('val')
    var conf = confirm('".Yii::$app->languages->getLanguage()['ntf_are_you_sure_you_want_to_withdraw']."?');
    if (conf){
        $.ajax({
            dataType: \"html\",
            type: \"POST\", 
            url:'/sendhelp/withdrawprofit', 
            data: {id_sh:id_sh, id_user:id_user}, 
            success: function (data) {
                $('.withdraw_alert_p').html('* '+data+' ".Yii::$app->languages->getLanguage()['ntf_btc_has_been_credited_to_your_main_balance']."');
                $('#withdraw_modal').modal('show');
            }
        });
    }else{
        return false;
    }  
})
")?>


<?=$this->registerJs("
    $('.Withdraw_capital').click(function(){
        var id_sh = $(this).attr('data')
        var id_user = $(this).attr('val')
        var conf = confirm('".Yii::$app->languages->getLanguage()['ntf_this_will_end_your_sh_do_you_want_to_continue']."?');
        if (conf){
            $.ajax({
                dataType: \"html\",
                type: \"POST\", 
                url:'/sendhelp/withdrawcapital', 
                data: {id_sh:id_sh, id_user:id_user}, 
                success: function (data) {
                    $('.withdraw_alert_p').html('* ".Yii::$app->languages->getLanguage()['ntf_you_have_just_withdrawn_profit_and_capital']." = '+data+' BTC');
                    $('#withdraw_modal').modal('show');
                }
            });
        }else{
            return false;
        }  
    })
")?>

<?=$this->registerJs("
$('#sendhelptransfer-amount').on('input', function() { 
    var amount = $(this).val();
    $.ajax({
        dataType: \"html\",
        type: \"POST\", 
        url:'/sendhelp/gettokenforsh', 
        data: {amount : amount}, 
        success: function (data) {
            $('#tokenforthissendhelp').html(data);
        }
    });
});
")?>





