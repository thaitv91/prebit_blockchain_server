<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;

$this->title = 'Charity Donors';
?>
<div class="pop-up-charity md-modal md-3d-slit" id="md-3d-slit">
    <div class="md-content">
        <div class="title-bar-box-popup">
            <div class="pull-left">
                <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Donation box</h3>
            </div>
            <div class="pull-right">
                <a class="md-close" title="close"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div>
            <?php $form = ActiveForm::begin(); ?>
                <div class="input-group ls-input">
                <p class="notify_amount"></p>
                    <?= $form->field($donors, 'amount')->textInput(['type'=>'number', 'maxlength' => true,'id'=>'current_amount', 'class' => 'form-control', 'placeholder' => 'Amount you wish to donate'])->label(false) ?>
                    <span class="input-group-addon">BTC</span>
                    
                </div>
                <div class="button-donate">
                    <button type="button" id="save_donate" class="btn btn-donate">DONATE</button>
                    <button type="button" id="reset_donate" class="btn btn-reset">RESET</button>
                </div>
                <p class="bottom-donate">
                    * Donation amount will be deducted from your PreBit wallet balance.
                </p>
            <?php ActiveForm::end(); ?>
        </div>
    </div><!-- End div .md-content -->
</div><!-- End div .md-modal .md-3d-slit -->

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>CHARITY DONORS</h2>
         Ultricies odio, mattis massa, etiam et, tempor
    </div>
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php if (Yii::$app->session->hasFlash('success')) { ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php } ?>
    </div>              
</div>
<div class="row charity-donors">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 charity-col charity-left">
        <div class="bg-white">           
            <div class="title-charity-donors">
                <div class="pull-left">
                    <h3>Donations Info</h3>
                    <p>Start date: <?php echo date('d-m-Y', $model->startday); ?> - End date: <?php echo date('d-m-Y', $model->endday); ?></p>
                </div>
                <div class="pull-right">
                    Total Donated: <br>
                    <span class="amount-p"><b><?=$model->getdonate($model->id); ?></b> BTC</span>
                </div>  
            </div>
            <div class="content-charity">
                <img style="width: 100%;height: auto;" src="<?= Yii::$app->params['site_url'] ?><?=$model->feature_images;?>" class="img-responsive">
                <h3><?=$model->title; ?></h3>

                <?=$model->content; ?>
                <?php $user_wallet = Yii::$app->user->identity->wallet; ?>
                <center>
                    <?php $today = strtotime(date('Y-m-d')); ?>
                    <?php if ($model->endday < $today) {
                        echo '';
                    }
                    else{
                        echo '<button data-modal="md-3d-slit" class="btn btn-success md-trigger">Donate Now</button>';
                    }
                    ?>                    
                </center> 
            </div>
        </div>
    </div><!--col-lg-6-->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 charity-col charity-right">
        <div class="bg-white">
            <div class="title-charity-donors">
                <div class="pull-left">
                    <h3>Donations List</h3>
                    <p>Created on: 07/07/2016 16:04</p>
                </div>
                <div class="pull-right">
                    <?php $today = strtotime(date('Y-m-d')); ?>
                    <?php if ($model->endday < $today) {
                        echo '';
                    }
                    else{
                        echo '<button data-modal="md-3d-slit" class="btn btn-success md-trigger">Donate Now</button>';
                    }
                    ?>                    
                </div>
            </div>
            <div class="content-charity">
               <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr class="tr-blue-x">
                                <th data-sortable="false">TIME</th>
                                <th data-sortable="false">USER</th>
                                <th data-sortable="false">DONATION AMOUNT</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php foreach ($listdonors as  $value): ?>
                                <tr>
                                    <td class="line-height40"><?php echo date('m-d-Y H:m:i A',$value->created_at); ?></td>
                                    <td class="line-height40"><?=$value->user->username; ?></td>
                                    <td class="green-number line-height40"><strong><?=$value->amount; ?> BTC</strong></td>                                                
                                </tr>
                            <?php endforeach ?>                                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--col-lg-6-->
</div>
<div class="md-overlay"></div>
<?=$this->registerJs("
$('#save_donate').click(function(){
    var current_amount = $('#current_amount').val();
    var charity_program = $model->amount;
    var id_program = $model->id;
    var wallet = $user_wallet;

    if(!current_amount){
        $('.notify_amount').html('Please fill in the amount !');
        $('.notify_amount').focus();
        return false;
    }
    if(current_amount > wallet ){
        $('.notify_amount').html('Your balance is not enough !');
        $('notify_amount').focus();
        return false;
    }
    $.ajax({
        type: \"POST\", 
        url:'/charitydonors/donate', 
        data: {current_amount:current_amount, id_program:$model->id, wallet:$user_wallet},
        success: function (data) {
            alert(data);
        }
    });

});
$('#reset_donate').click(function(){
    $('#current_amount').val('');    
}); 

");?>

