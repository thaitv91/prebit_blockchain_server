<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\TokenRequest;
use common\models\GiftUser;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>LUCKY DRAW</h2>
         Buy, transfer and check your token transaction history on this page
    </div>                    
</div>

<div class="row luckydraw-page token-history token-manager">
    <div class="col-md-12">
        <div class="bg-white">
            <div class="title-token-history">
                <h3>Buy Ticket</h3>
                <p>You currently have 0 available tickets. Last updated on 03/07/2016 12:23 AM</p>
            </div>
            <div class="widget">
                <div class="widget-content">
                	<div class="row">
                        Lucky program ended!     		
                	</div><!--row-->                	               	
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->

<div class="row-anylytist">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">My history</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="messages">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h5 class="title-win">My history</h5>
                <ul class="list-top-pl list-unstyled">
                <?php 
                if(!empty($user_gift)){
                    foreach ($user_gift as $keys => $usergift) {
                ?>
                    <li>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 intro-left">
                                <span class="number-ks"><?=$keys+1?></span>
                                <span class="avarta-ks"><img width="40" src="<?=Yii::$app->params['site_url'] ?>uploads/luckywheel/<?=$usergift->gift->thumbnail?>"></span>
                                <span class="text-ks"><?=$usergift->gift->name?></span>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <span class="text-time">
                                    <?php 
                                    if($usergift->status == GiftUser::STATUS_ACTIVE){
                                        echo '<b class="text-green">Received</b>';
                                    } else{
                                        echo '<b class="text-red">Waiting</b>';
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <span class="text-time"><?=date('d-m-Y - H:i',$usergift->created_at)?></span>
                            </div>
                        </div>
                    </li><!--item-->
                <?php
                    }
                }
                ?>
            </ul>
        </div>    
        </div>
    </div>
</div>


