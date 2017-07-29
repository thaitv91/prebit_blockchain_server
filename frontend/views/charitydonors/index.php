<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\MemberController;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;

$this->title = 'Charity Donation - PreBit';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2><?=Yii::$app->languages->getLanguage()['charity_donation']?></h2>
		<?=Yii::$app->languages->getLanguage()['you_can_help_us_raise_money_for_charity_here']?>
         
    </div>                    
</div>
<div class="row charity-donors-home">
    <?php foreach ($model as $key => $value): ?>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="bg-white">
                <img style="max-height: 380px; width: 100%;" src="<?= Yii::$app->params['site_url'] ?><?=$value->feature_images;?>" class="img-responsive">
                <h1 class="title-charitys"><?= $value->title ?></h1>
                <p>
                    <?php echo substr($value->content, 0,200).'...'; ?>
                </p>
                <?php
                    $today = strtotime(date('d-m-Y'));                    
                    $daytogo = $value->endday - $today;
                    if ($daytogo <= 0) {
                        echo '<a href="#" class="btn btn-success">Completed</a>';
                    }else{
                        echo '<a href="#" class="btn btn-warning">Incompleted</a>';
                    }
                ?>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="sp-bt">
                            <h3><?=$value->getdonate($value->id); ?> BTC</h3>
                            <p>funded</p>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="sp-bt sp-right">
                            <h3>
                                <?php                                    
                                    if ($daytogo > 0) {
                                        echo date('d', $daytogo).' '.'days'.'<p>to go</p>';
                                    }
                                    else{
                                        echo '';
                                    }
                                ?>                                        
                            </h3>
                            
                        </div>
                    </div>
                </div>
                <?php echo Html::a('View Info', '/charitydonors/view/'.$value->id, ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>'btn btn-default']) ?>
            </div>
        </div><!--col-lg-4-->
    <?php endforeach ?>    
</div>