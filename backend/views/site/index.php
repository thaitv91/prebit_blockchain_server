<?php

/* @var $this yii\web\View */

$this->title = 'Bitway system';
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Dashboard
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                overview &amp; stats
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="space-6"></div>

                <div class="col-ms-12">
                    <!-- thống kê user -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    User Traffic
                                </h5>

                                <div class="widget-toolbar no-border">
                                    <div class="inline dropdown-hover">
                                        <div class="input-group calendar-statistical">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                            <input class="form-control date-range-picker" type="text" name="date-range-picker-user" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid3">
                                            <span class="grey">
                                                User register
                                            </span>
                                            <h4 class="bigger pull-right user_register"><?=$user?></h4>
                                        </div>

                                        <div class="grid3">
                                            <span class="grey">
                                                User sendhelp
                                            </span>
                                            <h4 class="bigger pull-right user_sendhelp"><?=$shtransfer?></h4>
                                        </div>

                                        <div class="grid3">
                                            <span class="grey">
                                                User gethelp
                                            </span>
                                            <h4 class="bigger pull-right user_gethelp"><?=$ghtransfer?></h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- End / thống kê user -->

                    <div class="vspace-12-sm"></div>

                    <!-- thống kê total amount -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    Total Amount
                                </h5>

                                <div class="widget-toolbar no-border">
                                    <div class="inline dropdown-hover">
                                        <div class="input-group calendar-statistical">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                            <input class="form-control date-range-picker" type="text" name="date-range-picker-amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid3">
                                            <span class="grey">
                                                Total amount sh
                                            </span>
                                            <h4 class="bigger pull-right total_amountsh"><?php if(!empty($amountshtransfer)){ echo number_format($amountshtransfer, 5);}else{echo 0;}?></h4>
                                        </div>

                                        <div class="grid3">
                                            <span class="grey">
                                                Total amount gh
                                            </span>
                                            <h4 class="bigger pull-right total_amountgh"><?php if(!empty($amountghtransfer)){ echo number_format($amountghtransfer,5);}else{echo 0;}?></h4>
                                        </div>

                                        <div class="grid3">
                                            <span class="grey">
                                                Total amount buy token
                                            </span>
                                            <h4 class="bigger pull-right total_amountbuytoken"><?php if(!empty($amounttoken)){ echo number_format($amounttoken,8);}else{echo 0;}?></h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- END / thống kê total amount -->

                    <div class="vspace-12-sm"></div>
                    <div class="clear-fix"></div>
                </div>
                
                <div class="col-ms-12">
                    
                    <!-- thống kê gh balance/ bonus balance -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    GH Balance/Bonus Balance
                                </h5>

                                <div class="widget-toolbar no-border">
                                    <div class="inline dropdown-hover">
                                        <div class="input-group calendar-statistical">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                            <input class="form-control date-range-picker" type="text" name="date-range-picker-balance" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid2">
                                            <span class="grey">
                                                Total GH Balance
                                            </span>
                                            <h4 class="bigger pull-right total_ghbalance"><?=number_format($totalghbalance, 4)?></h4>
                                        </div>

                                        <div class="grid2">
                                            <span class="grey">
                                                Total Bonus Balance
                                            </span>
                                            <h4 class="bigger pull-right total_bonusbalance"><?=number_format($totalmanagerbonusbalance, 4)?></h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- END / kê gh balance/ bonus balance -->

                    <div class="vspace-12-sm"></div>

                    <!-- thống kê token -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    Token
                                </h5>

                                <div class="widget-toolbar no-border">
                                    <div class="inline dropdown-hover">
                                        <div class="input-group calendar-statistical">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                            <input class="form-control date-range-picker" type="text" name="date-range-picker-token" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid2">
                                            <span class="grey">
                                                Total buy token
                                            </span>
                                            <h4 class="bigger pull-right total_buytoken"><?php if(!empty($amountbuytoken)){ echo $amountbuytoken;}else{echo 0;}?></h4>
                                        </div>

                                        <div class="grid2">
                                            <span class="grey">
                                                Total transfer token
                                            </span>
                                            <h4 class="bigger pull-right total_transfertoken"><?php if(!empty($amounttransfertoken)){ echo $amounttransfertoken;}else{echo 0;}?></h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- END / thống kê token -->

                    <div class="clear-fix"></div>
                </div>

                <div class="col-ms-12">
                    <!-- thống kê balance sh bitcoin wallet -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    SH Bitcoin Wallet Balance
                                </h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid">
                                            <span class="grey">
                                                Total SH Bitcoin Wallet Balance
                                            </span>
                                            <h4 class="bigger pull-right"><?=$bitcoinwallet_balance?> BTC</h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- END / thống kê balance sh bitcoin wallet -->

                    <!-- thống kê Total members registered -->
                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    Total members registered
                                </h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>

                                    <div class="hr hr8 hr-double"></div>

                                    <div class="clearfix">
                                        <div class="grid">
                                            <span class="grey">
                                                Total member registered
                                            </span>
                                            <h4 class="bigger pull-right "><?=$total_userregister?></h4>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->
                    <!-- END / thống kê Total members registered -->


                </div>
            </div><!-- /.row -->      

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<div id="modal_loading" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm modal_loading" role="document">
    <div class="modal-content">
      <div style="margin-bottom:0;" class="progress progress-striped active"><div style="width: 100%" class="progress-bar"></div></div>
    </div>
  </div>
</div>

<?=$this->registerJs("$('.dialogs,.comments').ace_scroll({size: 300});");?>
<?=$this->registerJs("
$('input[name=date-range-picker-user]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $('#modal_loading').modal('show');   
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/ajax/userstatistical', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#modal_loading').modal('hide');   
            $('.user_register').html(data[0]);
            $('.user_sendhelp').html(data[1]);
            $('.user_gethelp').html(data[2]);
        }
    });
});
")?>


<?=$this->registerJs("
$('input[name=date-range-picker-amount]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $('#modal_loading').modal('show');   
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/ajax/totalamountstatistical', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#modal_loading').modal('hide');   
            $('.total_amountsh').html(data[0]);
            $('.total_amountgh').html(data[1]);
            $('.total_amountbuytoken').html(data[2]);
        }
    });
});
")?>

<?=$this->registerJs("
$('input[name=date-range-picker-token]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $('#modal_loading').modal('show');   
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/ajax/totaltoken', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#modal_loading').modal('hide');   
            $('.total_buytoken').html(data[0]);
            $('.total_transfertoken').html(data[1]);
        }
    });
});
")?>

<?=$this->registerJs("
$('input[name=date-range-picker-balance]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $('#modal_loading').modal('show');   
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/ajax/totalghbalance', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#modal_loading').modal('hide');   
            $('.total_ghbalance').html(data[0]);
            $('.total_bonusbalance').html(data[1]);
        }
    });
});
")?>



