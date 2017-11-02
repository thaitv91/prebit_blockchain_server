<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\GhTransfer;
use yii\grid\GridView;

$this->title = 'Withdraw - PreBit';
$bitcoin_rate = file_get_contents('https://blockchain.info/tobtc?currency=USD&value=1');
?>
<div class="withdraw-page">
    <div class="top-dashboard">
        <h2 class="title-general">Withdraw</h2>
    </div>

    <?php if ($token <= 0) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-danger">
                    Your Fee is not enough to perform this action
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="bg-trans-white">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="text-bonus-blance">
                            <h3>Indirect Bonus</h3>
                        </div>
                    </div><!--col-lg-7-->
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <h3 class="yellow-number"><?= number_format(($user->manager_bonus + $user->referral_bonus), 8) ?>
                            $</h3>
                        <h3 class="yellow-number"><?= number_format(($user->manager_bonus + $user->referral_bonus) * $bitcoin_rate, 8) ?>
                            BTC</h3>
                    </div><!--col-lg-5-->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-top20">

                        <div id="form-show-bonus">
                            <h4 class="title-get-hep">Withdraw</h4>
                            <?php
                            if ($user->token <= 0) {
                                echo '<div class="content-main-show">
                                    <img src="' . Yii::$app->params['site_url'] . 'images/icon-main-thang.png" alt="" class="img-responsive">

                                    <button class="btn btn-warning">PURCHASE FEE</button>
                                    <button class="btn btn-cancel">CANCEL</button>
                                </div>';
                            } else {
                                ?>

                                <!-- alert div -->
                                <?php if (Yii::$app->session->hasFlash('error_bonus')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <?= Yii::$app->session->getFlash('error_bonus') ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (Yii::$app->session->hasFlash('success_bonus')): ?>
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <?= Yii::$app->session->getFlash('success_bonus') ?>
                                    </div>
                                <?php endif; ?>
                                <!-- End / alert div -->


                                <!-- form gh bonus wallet -->
                                <?php $form = ActiveForm::begin(['id' => 'model_bonus']); ?>
                                <div class="form-group">
                                    <label for="bk-wallet">PreBit Wallet</label>
                                    <div type="text" class="form-control form-wallet"
                                         id="bk-wallet"><?= $address_btc[0] ?></div>
                                </div>
                                <?= $form->field($model_bonus, 'amount', ['template' => '<div class="pos-re">{input}<span class="form-control-feedback" aria-hidden="true">$</span>{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Amount', 'class' => 'form-control', 'required' => 'required', 'step' => '0.001', 'type' => GhTransfer::STATUS_BONUS])->label(false) ?>

                                <div class="pull-left pad0mobi">
                                    <a class="btn btn-transpa btn-cancel">Requires <b><span
                                                    id="tokenforgh<?= GhTransfer::STATUS_BONUS ?>">0</span></b> POINT(s)</a>
                                </div>
                                <div class="pull-right btn-group">
                                    <?= Html::submitButton('GET DOLLA', ['class' => 'btn btn-gh']) ?>
                                    <button type="reset" class="btn btn-cancel">CANCEL</button>
                                </div>
                                <?php ActiveForm::end(); ?>
                                <!-- End / form gh bonus wallet -->


                            <?php } ?>
                        </div>

                    </div><!--col-lg-12-->
                </div><!--row-->
            </div><!--bg-trans-white-->
        </div><!--col-lg-6-->
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="bg-trans-white">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="text-bonus-blance">
                            <h3>Profit</h3>
                        </div>
                    </div><!--col-lg-7-->
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <h3 class="yellow-number"><?= number_format($user->wallet, 8); ?> $</h3>
                        <h3 class="yellow-number"><?= number_format($user->wallet * $bitcoin_rate, 8); ?> $</h3>
                    </div><!--col-lg-5-->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-top20">
                        <div id="form-show-main">
                            <h4 class="title-get-hep">Withdraw</h4>
                            <?php
                            if ($user->token <= 0) {
                                echo '<div class="content-main-show">
                                    <img src="' . Yii::$app->params['site_url'] . 'images/icon-main-thang.png" alt="" class="img-responsive">

                                    <button class="btn btn-warning">PURCHASE FEE</button>
                                    <button class="btn btn-cancel">CANCEL</button>
                                </div>';
                            } else {
                                ?>

                                <!-- alert div -->
                                <?php if (Yii::$app->session->hasFlash('error_main')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <?= Yii::$app->session->getFlash('error_main') ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (Yii::$app->session->hasFlash('success_main')): ?>
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <?= Yii::$app->session->getFlash('success_main') ?>
                                    </div>
                                <?php endif; ?>
                                <!-- End / alert div -->

                                <!-- form gh main wallet -->
                                <?php $form = ActiveForm::begin(['id' => 'model_main']); ?>
                                <div class="form-show-bk">
                                    <div class="form-group">
                                        <label for="bk-wallet">PreBit Wallet</label>
                                        <div type="text" class="form-control form-wallet"
                                             id="bk-wallet"><?= $address_btc[0] ?></div>
                                    </div>
                                    <?= $form->field($model_main, 'amount', ['template' => '<div class="pos-re">{input}<span class="form-control-feedback" aria-hidden="true">$</span>{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Amount', 'class' => 'form-control', 'required' => 'required', 'step' => '0.001', 'type' => GhTransfer::STATUS_MAIN])->label(false) ?>
                                    <!-- <div class="form-group pos-re">
                                        <input type="text" class="form-control" id="bk-wallet" placeholder="Amount to be transferred">
                                        <span class="form-control-feedback" aria-hidden="true">$</span>
                                    </div> -->

                                    <div class="pull-left pad0mobi">
                                        <a class="btn btn-transpa btn-cancel">Requires <b><span
                                                        id="tokenforgh<?= GhTransfer::STATUS_MAIN ?>">0</span></b>
                                            POINT(s)</a>
                                    </div>
                                    <div class="pull-right btn-group">
                                        <?= Html::submitButton('GET DOLLA', ['class' => 'btn btn-gh']) ?>
                                        <button type="reset" class="btn btn-cancel">CANCEL</button>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                                <!-- End / form gh main wallet -->


                            <?php } ?>

                        </div>
                    </div><!--col-lg-12-->
                </div><!--row-->
            </div><!--bg-trans-white-->
        </div><!--col-lg-6-->
    </div><!--row1-->
    <div class="row">
        <div class="col-md-12">
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
                                'label' => 'Time',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return date('d/m/Y H:i',$data->created_at);
                                }
                            ],
                            [
                                'label' => 'Amount',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return  $data->amount.' $';
                                }
                            ],
                            [
                                'label' => 'Source',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    if($data->status == GhTransfer::STATUS_MAIN){
                                        $source = 'Main Balance';
                                    }
                                    if($data->status == GhTransfer::STATUS_BONUS){
                                        $source = 'Bonus Balance';
                                    }
                                    return  $source;
                                }
                            ],
                            [
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    if($data->publish == GhTransfer::PUBLISH_NOACTIVE){
                                        $publish = '<span class="color-pending">Pending</span>';
                                    }
                                    if($data->publish == GhTransfer::PUBLISH_ACTIVE){
                                        $publish = '<span class="color-complete">Complete</span>';
                                    }
                                    return  $publish;
                                }
                            ],
                            
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table'],
                    ]); ?>
                </div>

            </div>
        </div>
    </div><!--row2-->
</div>

<?= $this->registerJs("
$('#ghbonuswallet-amount').on('input', function() { 
    var amount = $(this).val();
    var type = $(this).attr('type');
    $.ajax({
        dataType: \"html\",
        type: \"POST\", 
        url:'/gethelp/gettokenforghbonus', 
        data: {amount : amount, type : type}, 
        success: function (data) {
            $('#tokenforgh'+type).html(data);
        }
    });
});
") ?>

<?= $this->registerJs("
$('#ghtransfer-amount').on('input', function() { 
    var amount = $(this).val();
    var type = $(this).attr('type');
    $.ajax({
        dataType: \"html\",
        type: \"POST\", 
        url:'/gethelp/gettokenforghbonus', 
        data: {amount : amount, type : type}, 
        success: function (data) {
            $('#tokenforgh'+type).html(data);
        }
    });
});
") ?>
