<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\MemberController;
use common\models\User;
use common\models\CharityProgram;
use common\models\ShTransfer;
use common\models\GhTransfer;

$this->title = 'Top 10 Members - PreBit';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>TOP 10</h2>
         View Top PreBit Members here
    </div>                    
</div>
<div class="row top-10-page">
   <div class="widget-content padding">
        <ul id="top-10-tab" class="nav nav-tabs">
            <li class="active">
                <a href="#top-sh" data-toggle="tab">Top SH Members</a>
            </li>
            <li class="">
                <a href="#top-leader" data-toggle="tab">Top Leaders</a>
            </li>
            <li class="">
                <a href="#top-charity" data-toggle="tab">Top 10 Charity Donors</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="top-sh">
                <div class="widget-toolbar no-border col-md-4 col-md-offset-4" style="margin-bottom: 20px;">
                    <div class="inline dropdown-hover">
                        <div class="input-group calendar-statistical">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-range-picker" type="text" name="date-range-picker-sh" />                            
                        </div>
                    </div>
                </div>
                <div class="list-hap">
                    <div id="list-data-sh">
                        <?php foreach ($data_sh as $key => $value): ?>
                            <?php if ($key < 3) { ?>
                                <?php $user = User::findOne($value); ?>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="avatar-top <?php echo 'top-'.$key?>">
                                        <?php if (!empty($user->avatar)) {
                                            echo '<img src="';
                                            echo Yii::$app->params['url_file'];
                                            echo '/uploads/users/';
                                            echo $user->avatar.'"';
                                            echo 'class="img-responsive img-1">';
                                        }else{
                                            echo '<img src="';
                                            echo Yii::$app->params['url_file'];
                                            echo '/uploads/users/default-avatar.jpg"';
                                            echo 'class="img-responsive img-1">';
                                        }
                                        ?>                               
                                        <div class="set-top">
                                            <?php if ($key == 0) {
                                                echo '<img src="';
                                                echo Yii::$app->params['url_file'];
                                                echo '/images/top-1.png"';                    
                                                echo 'class="img-responsive img-2">';
                                            }
                                            elseif ($key == 1) {
                                                echo '<img src="';
                                                echo Yii::$app->params['url_file'];
                                                echo '/images/top-2.png"';                    
                                                echo 'class="img-responsive img-2">';
                                            }
                                            else{
                                                echo '<img src="';
                                                echo Yii::$app->params['url_file'];
                                                echo '/images/top-3.png"';                    
                                                echo 'class="img-responsive img-2">';
                                            } 
                                            ?>
                                        </div>                            
                                    </div>
                                    <h2 class="title-range"><?=$user->username;?></h2>
                                </div>
                            <?php } ?>
                        <?php endforeach ?>
                    </div>                  
                </div>
                <div class="table-bot">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table id ="data-user-sh" data-sortable class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/top-icon-i.png"> Top</th>                                           
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/users/i-status.png"> Member</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/ib-rank.png"> Level</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/users/i-total-sh.png"> Send Help Amount</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>

                                            <?php foreach ($data_sh as $key =>  $value): ?>
                                                <?php if ($key < 10) { ?>
                                                    <?php $user = User::findOne($value); ?>
                                                    <tr>
                                                        <td>
                                                            <div class="bor-number">
                                                                <?=$key + 1?> 
                                                            </div>
                                                        </td>
                                                        <td><?=$user->username; ?></td>
                                                        <td>
                                                            <?php
                                                                $rank = $user->level;
                                                                switch ($rank)
                                                                {
                                                                    case 0 :
                                                                        echo '';
                                                                        break;
                                                                    case 1:
                                                                        echo 'Bronze';
                                                                        break;
                                                                    case 2:
                                                                        echo 'Silver';
                                                                        break;
                                                                    case 3:
                                                                        echo 'Gold';
                                                                        break;
                                                                    case 4 :
                                                                        echo 'Platinum';
                                                                        break;
                                                                    case 5 :
                                                                        echo 'Diamond';
                                                                        break;
                                                                    case 6 :
                                                                        echo 'Master';
                                                                        break;
                                                                    case 7 :
                                                                        echo 'Grandmaster';
                                                                        break;
                                                                    case 8 :
                                                                        echo 'Legendary';
                                                                        break;
                                                                    default:
                                                                        echo '';
                                                                        break;
                                                                }
                                                            ?> 
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($user->getUserSh($user->id))) {                                                           
                                                                echo number_format($user->getUserSh($user->id), 8, '.', '').' '.'BTC';                                                            
                                                            }else
                                                            {
                                                                echo '0 BTC';
                                                            } 
                                                            ?> 
                                                        </td>                                                                                                 
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach ?>                                                                                       
                                        </tbody>
                                    </table>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>                   
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="top-leader">
                <div class="widget-toolbar no-border col-md-4 col-md-offset-4" style="margin-bottom: 20px;">
                    <div class="inline dropdown-hover">
                        <div class="input-group calendar-statistical">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-range-picker" type="text" name="date-range-picker-user" />                            
                        </div>
                    </div>
                </div>
                <div class="list-hap">                
                <div id ="user_top_leader">
                    <?php
                        foreach ($dataleader1 as $key => $lv2) {
                            $user = User::findOne($lv2);
                    ?>                       
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="avatar-top <?php echo 'top-'.$key?>">
                                <?php
                                    if (!empty($user->avatar)) {
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/uploads/users/';
                                        echo $user->avatar.'"';
                                        echo 'class="img-responsive img-1">';
                                    }else{
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/uploads/users/default-avatar.jpg"';
                                        echo 'class="img-responsive img-1">';
                                    }                            
                                ?>                               
                                <div class="set-top">
                                    <?php if ($key == 0) {
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/images/top-1.png"';                    
                                        echo 'class="img-responsive img-2">';
                                    }
                                    elseif ($key == 1) {
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/images/top-2.png"';                    
                                        echo 'class="img-responsive img-2">';
                                    }
                                    else{
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/images/top-3.png"';                    
                                        echo 'class="img-responsive img-2">';
                                    } 
                                    ?>
                                </div>                            
                            </div>
                            <h2 class="title-range">
                                <?=$user->username; ?>
                            </h2>
                        </div>
                    <?php } ?>
                    </div>                
                </div>
                <div class="table-bot">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table id = "top2_user_leader" data-sortable class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/top-icon-i.png"> Top</th>                                           
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/users/i-status.png"> Member</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/ib-rank.png"> Level</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/ib-top.png"> Direct Members</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                                <?php 
                                                    foreach ($dataleader as $key => $lv2) {
                                                        $user = User::findOne($lv2);
                                                ?>                                        
                                                    <tr>
                                                        <td>
                                                            <div class="bor-number">
                                                                <?=$key + 1?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?=$user->username;?>
                                                        </td>
                                                        <td>                                                        
                                                           <?php
                                                                $rank = $user->level;
                                                                switch ($rank)
                                                                {
                                                                    case 0 :
                                                                        echo '';
                                                                        break;
                                                                    case 1:
                                                                        echo 'Bronze';
                                                                        break;
                                                                    case 2:
                                                                        echo 'Silver';
                                                                        break;
                                                                    case 3:
                                                                        echo 'Gold';
                                                                        break;
                                                                    case 4 :
                                                                        echo 'Platinum';
                                                                        break;
                                                                    case 5 :
                                                                        echo 'Diamond';
                                                                        break;
                                                                    case 6 :
                                                                        echo 'Master';
                                                                        break;
                                                                    case 7 :
                                                                        echo 'Grandmaster';
                                                                        break;
                                                                    case 8 :
                                                                        echo 'Legendary';
                                                                        break;
                                                                    default:
                                                                        echo '';
                                                                        break;
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?=count($user->getUserReferral($user->id)); ?>
                                                        </td>                                     
                                                    </tr>
                                                <?php }  ?>                                                                             
                                        </tbody>
                                    </table>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>  
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="top-charity">
                <div class="widget-toolbar no-border col-md-4 col-md-offset-4" style="margin-bottom: 20px;">
                    <div class="inline dropdown-hover">
                        <div class="input-group calendar-statistical">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                            <input class="form-control date-range-picker" type="text" name="date-range-picker-charity" />                            
                        </div>
                    </div>
                </div>
                <div class="list-hap">
                    <div id="data_top_charity">
                        <?php foreach ($data_charity as $key => $value): ?> 
                             <?php $user = User::findOne($value); ?>        
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="avatar-top <?php echo 'top-'.$key?>">
                                    <?php if (!empty($user->avatar)) {
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/uploads/users/';
                                        echo $user->avatar.'"';
                                        echo 'class="img-responsive img-1">';
                                    }else{
                                        echo '<img src="';
                                        echo Yii::$app->params['url_file'];
                                        echo '/uploads/users/default-avatar.jpg"';
                                        echo 'class="img-responsive img-1">';
                                    }
                                    ?>                               
                                    <div class="set-top">
                                        <?php if ($key == 0) {
                                            echo '<img src="';
                                            echo Yii::$app->params['url_file'];
                                            echo '/images/top-1.png"';                    
                                            echo 'class="img-responsive img-2">';
                                        }
                                        elseif ($key == 1) {
                                            echo '<img src="';
                                            echo Yii::$app->params['url_file'];
                                            echo '/images/top-2.png"';                    
                                            echo 'class="img-responsive img-2">';
                                        }
                                        else{
                                            echo '<img src="';
                                            echo Yii::$app->params['url_file'];
                                            echo '/images/top-3.png"';                    
                                            echo 'class="img-responsive img-2">';
                                        } 
                                        ?>
                                    </div>                            
                                </div>
                                <h2 class="title-range"><?=$user->username;?></h2>
                            </div>
                        <?php endforeach ?>
                    </div>                
                </div>
                <div class="table-bot">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table id = "data-charity" data-sortable class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/top-icon-i.png"> Top</th>                                           
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/users/i-status.png"> Member</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/ib-rank.png"> Level</th>
                                                <th><img src="<?= Yii::$app->params['url_file'] ?>/images/top10/ib-donate.png"> Charity Donors</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>

                                            <?php foreach ($data_charity as $key =>  $value): ?>
                                                <?php $user = User::findOne($value); ?>
                                                <tr>
                                                    <td>
                                                        <div class="bor-number">
                                                            <?=$key + 1?> 
                                                        </div>
                                                    </td>
                                                    <td><?=$user->username; ?></td>
                                                    <td>
                                                        <?php
                                                            if ($user->level == User::BRONZE) {
                                                                echo "Bronze";
                                                            }elseif ($user->level == User::SILVER) {
                                                                echo "Silver";
                                                            }
                                                            elseif ($user->level == User::GOLD) {
                                                                echo "Gold";
                                                            }
                                                            elseif ($user->level == User::PLATINUM) {
                                                                echo "Platinum";
                                                            }
                                                            elseif ($user->level == User::DIAMOND) {
                                                                echo "Diamond";
                                                            }
                                                            elseif ($user->level == User::MASTER) {
                                                                echo "Master";
                                                            }
                                                            elseif ($user->level == User::GRANDMASTER) {
                                                                echo "Grandmaster";
                                                            }
                                                            elseif ($user->level == User::LEGENDARY) {
                                                                echo "Legendary";
                                                            }
                                                        ?>
                                                    </td>                                                    
                                                    <td>
                                                         <?php if (!empty($user->getUserDn($user->id))) {
                                                            echo $user->getUserDn($user->id).' '.'BTC';
                                                        }else
                                                        {
                                                            echo '0 BTC';
                                                        } 
                                                        ?>                                                       
                                                    </td>                                                
                                                </tr>
                                            <?php endforeach ?>                                                                                       
                                        </tbody>
                                    </table>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>  
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->
        
    </div>
</div>
<?=$this->registerJs("
$('input[name=date-range-picker-user]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/top10/usertop', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#user_top_leader').html(data[0]);
            $('#top2_user_leader').html(data[1]);
        }
    });
});
")?>
<?=$this->registerJs("
$('input[name=date-range-picker-sh]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/top10/usersh', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#list-data-sh').html(data[0]);
            $('#data-user-sh').html(data[1]);
        }
    });
});
")?>
<?=$this->registerJs("
$('input[name=date-range-picker-charity]').on('apply.daterangepicker', function(ev, picker) {
    var date = $(this).val();
    var dateto = date.substr(0, 10);
    var datefrom = date.substr(date.length - 10);
    $.ajax({
        dataType:\"json\",
        type: \"POST\", 
        url:'/top10/usercharity', 
        data: {dateto : dateto, datefrom : datefrom}, 
        success: function (data) {
            $('#data_top_charity').html(data[0]);
            $('#data-charity').html(data[1]);
        }
    });
});
")?>