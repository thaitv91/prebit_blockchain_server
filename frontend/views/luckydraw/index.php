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
                <p>You currently have <span class="amountticket"><?=$User->ticket?></span> available tokens. Last updated on 03/07/2016 12:23 AM</p>
            </div>
            <div class="widget">
                <div class="widget-content">
                	<div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <p class="ve_cl">
                                <img src="<?=Yii::$app->params['site_url'];?>images/luckydraw/icon_cl.png" class="img-responsive"> 
                                &nbsp; 
                                <b>Your Lucky Ticket balance: <span class="amountticket" style="color: red"><?=$User->ticket?></span></b>
                            </p>
                            <div class="button-spin">
                                <?php if($User->ticket > 0){  ?>
                                <button id ="spin-spin" type="submit" class="btn btn-warning" onClick="startSpin();">SPIN</button><br>
                                <button  class="btn btn-info" onClick="resetWheel(); return false;">Play again</button><br>
                                <a id ="spin-buy" href="<?=Yii::$app->params['site_url'];?>tickettransfer/index" class="btn btn-success">Buy Ticket</a></br>
                                <p class="ticketzero">(*You need Tickets to participate Lucky Draw)</p>
                                <?php } else { ?>
                                <button id ="spin-spin" type="submit" class="btn btn-warning">SPIN</button><br>

                                <button class="btn btn-info">Play again</button><br>

                                <a id ="spin-buy" href="<?=Yii::$app->params['site_url'];?>tickettransfer/index" class="btn btn-success">Buy Ticket</a><br>
                                
                                <p>(*Bạn cần có Ticket để tham gia vòng quay may mắn)</p>
                                <?php }?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div width="438" height="582" class="the_wheel" align="center" valign="center">
                                <canvas id="canvas" width="434" height="434">
                                    <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                                </canvas>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="z-index: 1">
                            <p><b>Prize list : </b></p>

                            <?php if(!empty($GiftLuckywheel)){ 
                                foreach ($GiftLuckywheel as $key => $gift) {
                            ?>
                                <div class="item-gt">
                                    <div class="text-gt"><?=$gift->getGift($gift->id_gift)->name;?></div>
                                    <div class="circle-gt">
                                        <img src="<?=Yii::$app->params['site_url'];?>uploads/luckywheel/<?=$gift->getGift($gift->id_gift)->thumbnail;?>" class="img-responsive">
                                    </div>
                                </div><!--item-gt-->
                            <?php        
                                }
                            }
                            ?>
                        </div><!--right-->               		
                	</div><!--row-->                	               	
                </div>
            </div>
        </div>
    </div>
</div><!--token-history-->
<div class="row-anylytist">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#top-player" aria-controls="home" role="tab" data-toggle="tab">Top Players Win Oodles!</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Game Overview</a></li>
        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">My history</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="top-player">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h5 class="title-win">Lucky draw winner list</h5>
                <ul class="list-top-pl list-unstyled">
                    <?php 
                    if(!empty($user_winers)){
                        foreach ($user_winers as $key => $winner) {
                    ?>
                    <li>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 intro-left">
                                <span class="number-ks"><?=$key+1?></span>
                                <span class="avarta-ks"><img width="40" src="<?=Yii::$app->params['site_url'] ?>uploads/users/<?=$winner->user->avatar?>"></span>
                                <span class="text-ks"><?=$winner->user->username?></span>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 intro-left">
                                <span class="avarta-ks"><img width="40" src="<?=Yii::$app->params['site_url'] ?>uploads/luckywheel/<?=$winner->gift->thumbnail?>"></span>
                                <span><?=$winner->gift->name?></span>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <span class="text-time"><?=date('d-m-Y - H:i',$winner->created_at)?></span>
                            </div>
                        </div>
                    </li><!--item-->
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>         
        </div><!--top-player-->
        <div role="tabpanel" class="tab-pane" id="profile">...</div>
        <div role="tabpanel" class="tab-pane" id="messages">
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
<!--endtab-->

<input id="ticket" type="hidden" value="<?=$User->ticket?>">
<input id="Userlogin" type="hidden" value="<?=$User->id?>">
<input id="Luckywheel" type="hidden" value="<?=$LuckyWheel->id?>">

<div class="modal fade bs-example-modal-md" id="success_luckydraw" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog pop-up-charity" role="document">
        <div class="modal-content md-content ">
            <div class="title-bar-box-popup">
                <div class="pull-left">
                    <h3><img class="charity-img-left-box" src="<?=Yii::$app->params['site_url'] ?>images/i-charity-box.png">Luckydraw</h3>
                </div>
                <div class="pull-right">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
            </div>
            <div>
                <p id="alert_luckydraw" class="bottom-donate">
                    Ticket transfer was successful
                </p>
                <div class="button-donate">
                    <button onClick="reload_page()" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>    
        </div>
    </div>
</div>


<script type="text/javascript" src="<?= Yii::$app->params['url_file'] ?>/js/Winwheel.js"></script>
<script type="text/javascript">
    var theWheel = new Winwheel({
        'outerRadius'     : 212,        // Set outer radius so wheel fits inside the background.
        'innerRadius'     : 75,         // Make wheel hollow so segments don't go all way to center.
        'textFontSize'    : 24,         // Set default font size for the segments.
        'textOrientation' : 'horizontal', // Make text vertial so goes down from the outside of wheel.
        'textAlignment'   : 'outer',    // Align text to outside of wheel.
        'numSegments'     : <?=count($SpinWheel)?>,         // Specify number of segments.
        'segments'        :             // Define segments including colour and text.
        [                               // font size and test colour overridden on backrupt segments.
            <?php 
            foreach ($SpinWheel as $key => $spin) {
                echo "{'fillStyle' : '".$spin->getGift($spin->id_gift)->color."', 'text' : '".$spin->getGift($spin->id_gift)->name."', 'textFillStyle' : '#ffffff', 'gift' : ".$spin->id_gift.", 'user' : ".$User->id." , 'luckywheel' : ".$spin->id_luckywheel."},";
            }
            ?>
            
        ],
        'animation' :           // Specify the animation to use.
        {
            'type'     : 'spinToStop',
            'duration' : 10,     // Duration in seconds.
            'spins'    : 10,     // Default number of complete spins.
            'callbackFinished' : 'alertPrize()'
        }
    });
</script>
