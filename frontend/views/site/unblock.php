<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Unblock - Bitway';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bg-white">
    <div class="title-token-history">
        <h3>Unlock Page</h3>
        <p>Your account has been blocked</p>
    </div>

    <?php 
    if(!empty($blocklistuser)){
    ?>
        <div class="widget">
            <!-- alert -->
            <?php if(Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if(Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            
            <!-- END alert -->
            <div class="widget-content">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="info">
                        <p>You are seeing this page because your account has been blocked. In order to remove your account blockage, please send <?=$fineamount?> BTC to the Bitcoin address displayed below then press UNBLOCK. Please do not press UNBLOCK if you have not sent the money yet. Your request will be reviewed within 24 hours. Thank you.</p><br></br>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 col-lg-offset-1">
                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=<?=$account_wallettoken?>" alt="QR Code" class="img-responsive">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                            <h5 class="title-i">BTC Amount to unlock your account</h5>
                            <h3 class="green-number"><?=$fineamount?> BTC</h3>
                            <p>Bitcoin Address</p>
                            <?php $form = ActiveForm::begin(['layout' => 'inline', 'id' => 'login-form']);?>
                                <?= $form->field($blockList, 'amount')->textInput(['type' => 'hidden', 'value'=>$fineamount])->label(false) ?>
                                <div class="form-group has-feedback">
                                    <div class="input-group">                                                            
                                        <div class="form-control" id="inputGroupSuccess3"><?=$account_wallettoken?></div>
                                        <span class="input-group-addon"><img src="<?= Yii::$app->params['site_url'] ?>images/icon-wallet-address.png"></span>
                                    </div>
                                </div>
                                <div class="unlock-group">
                                    <?= Html::submitButton('UNLOCK', ['class' => 'btn btn-primary form-control', 'name' => 'login-button']) ?>
                                    <a href="#" class="btn btn-default">CANCEL</a>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div> <!-- / .tab-pane -->
                </div> <!-- / .tab-content -->
            </div>
        </div>
    <?php } else {?>  
        <div class="widget">
            <div class="alert alert-success" role="alert">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    You unblock request has been sent. A member of PreBit staff will get back to you soon!
            </div>
        </div>  
    <?php } ?>
</div>