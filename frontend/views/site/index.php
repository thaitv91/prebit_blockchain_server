<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\CharityProgram;
use common\models\CharityDonors;

$this->title = 'Member Dashboard - PreBit';
?>

<table width="100%" height="100">
<tr><td>
            <div class="">

                <div class="top-summary">
                    <div class="top-dashboard">
                        <h2 class="title-general"><?=Yii::$app->languages->getLanguage()['dashboard']?></h2>
                    </div> 
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="widget green-1 animated fadeInDown">
                                <div class="widget-content padding">
                                    <div class="row">
                                        <div class="text-box col-lg-8">
                                            <p class="maindata">Wallet</p>
                                            
                                            <h2><span data-duration="3000" data-value="<?=number_format($balance_btc, 8);?>" class="animate-number"><?=number_format($balance_btc, 8);?> BTC</span></h2>
                                        </div>
                                        <div class="col-lg-4 icon-btc icon-wallet hidden-xs">
                                            <img src="<?=Yii::$app->params['site_url'];?>images/icon-wallet.png">
                                        </div>
                                    </div>
                                </div>                          
                            </div>
                        </div><!--col-lg-3-->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="widget darkblue-2 animated fadeInDown">
                                <div class="widget-content padding">
                                    <div class="row">
                                        <div class="text-box col-lg-8">
                                            <p class="maindata">Profit</p>
                                            <h2><span data-duration="3000" data-value="<?=$user->wallet;?>" class="animate-number"><?=number_format($user->wallet, 8);?> BTC</span></h2>
                                        </div>
                                        <div class="col-lg-4 icon-btc icon-blance hidden-xs">
                                            <img src="<?=Yii::$app->params['site_url'];?>images/icon-blance.png">
                                        </div>
                                    </div>
                                </div>                          
                            </div>
                        </div><!--col-lg-3-->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="widget pink-1 animated fadeInDown">
                                <div class="widget-content padding">
                                    <div class="row">
                                        <div class="text-box col-lg-8">
                                            <p class="maindata">Bonus</p>
                                            <h2><span data-duration="3000" data-value="<?=$user->manager_bonus + $user->referral_bonus ;?>" class="animate-number"><?=number_format( ($user->manager_bonus + $user->referral_bonus) , 8) ;?> BTC</span></h2>
                                        </div>
                                        <div class="col-lg-4 icon-btc icon-bonus hidden-xs">
                                            <img src="<?=Yii::$app->params['site_url'];?>images/icon-bonus.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--col-lg-3-->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="widget pink-1 last animated fadeInDown">
                                <div class="widget-content padding">
                                    <div class="row">
                                        <div class="text-box col-lg-8">
                                            <p class="maindata">Total Earning</p>
                                            <h2><span data-duration="3000" data-value="<?=$user->manager_bonus + $user->referral_bonus ;?>" class="animate-number"><?=number_format( ($user->wallet + $user->manager_bonus + $user->referral_bonus + $user->has_withdrawn) , 8) ;?> BTC</span></h2>
                                        </div>
                                        <div class="col-lg-4 icon-btc icon-bonus hidden-xs">
                                            <img src="<?=Yii::$app->params['site_url'];?>images/icon-total.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--col-lg-3-->

                    </div>
                </div><!--top-summary-->

                <div class="row btc-days-row">
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
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 marginbot20">
                        <div class="btc-days">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-8 col-sm-12">
                                            <div class="title-btc">
                                                <div class="sh-left">
                                                    <h1><?=$value->amount?> BTC</h1>
                                                    <!--<p>ID: <?=Yii::$app->params['prefix_id'] + $value->id?></p>-->
                                                </div>
                                                <div class="sh-right">
                                                    <p class="start-normal">Start Date: <?=date('d-m-Y', $value->created_at)?></p>
                                                </div>

                                                <div class="mobile-float">
                                                    <b><?=Yii::$app->languages->getLanguage()['sh_distributed']?></b>
                                                    <?php if(!empty($sh_withdraw)){?>
                                                    <p><?=Yii::$app->languages->getLanguage()['last_profit_withdraw_on']?> <?=date('H:i d-m-Y', ($value->inc_days))?></p>
                                                    <?php }?>
                                                </div><!-- mobile-float-->
                                            </div><!--title-btc-->
                                        </div>

                                        <div class="col-xs-4 col-sm-12">
                                            <div class="bol-circle">
                                                <h1><?=floor($datediff/(60*60*24));?></h1>
                                                <p><?php if(floor($datediff/(60*60*24)) > 1){ echo 'DAYS';} else { echo 'DAY';}?></p>
                                            </div>                                    
                                        </div><!--col-xs-4-->
                                    </div>
                                                               
                                </div><!-- col-md-6 -->
                                <div class="col-sm-6">
                                    <div class="center-mobi">
                                        <div>
                                            <div class="withdraw">
                                                <div class="pull-right2">
                                                    <p><?=Yii::$app->languages->getLanguage()['withdrawable_profit']?></p>
                                                    <h4 id="Withdrawable_profit_<?=$key?>" class="green-with"><?=number_format($amount_profit, 8)?></h4>
                                                </div>
                                            </div><!--col-xs-6-->
                                            <div class="withdraw">
                                                <div class="pull-right2">
                                                    <p><?=Yii::$app->languages->getLanguage()['total_profit_withdrawn']?></p>
                                                    <h4 id="Total_profit_<?=$key?>" class="green-with"><?=number_format($value->gettotalprofit($value->id), 8);?></h4>
                                                </div>
                                            </div><!--col-xs-6-->                                        
                                        </div>
                                    </div><!--center-mobi-->
                                </div><!-- col-md-6 -->
                            </div>
                            
                            <div class="content-btc">                           
                                <div class="send-bottom">
                                    <div class="col-md-12">
                                        <div class="pull-right view-more-btc">
                                            <i class="fa fa-arrow-circle-right"></i>
                                            <?=Html::a('View detail', '/sendhelp/index/', ['title' => Yii::t('app', 'sendhelp')]);?>
                                        </div>
                                    </div>
                                </div>
                            </div><!--content-btc-->
                        </div><!--btc-days-->
                    </div><!--col-lg-6-->    
                    <?php }?>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 marginbotmobile hidden-xs">
                        <div class="title-btc-donate">
                            <h2>donations</h2>
                        </div>                        
                        <?php foreach ($program as $key => $value): ?>
                            <?php
                                $today = strtotime(date('d-m-Y'));
                                $daytogo = $value->endday - $today;
                                if ($daytogo > 0) {
                            ?>
                                <div class="content-btc-donate">
                                    <img style="max-height: 380px; width: 100%;" src="<?= Yii::$app->params['site_url'] ?><?=$value->feature_images;?>" class="img-responsive">
                                    <div class="title-charity-prog">
                                        <h3><?=$value->title;?></h3>
                                    </div>
                                    <div class="button-btc-donate">
                                        <?php echo Html::a('Read More', '/charitydonors/view/'.$value->id, ['title' => $value->title,'data-pjax' => '0', 'class'=>'btn btn-default']) ?>
                                        <?php echo Html::a('Donate Now', '/charitydonors/view/'.$value->id, ['title' => $value->title,'data-pjax' => '0', 'class'=>'btn btn-success']) ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endforeach ?>                                              
                    </div><!--col-lg-6-->               
                </div><!--btc-days-row-->
	
    </div>
</td></tr>
</table>	
	
	
	
	
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

                                      
