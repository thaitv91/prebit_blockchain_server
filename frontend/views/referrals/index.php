<?php 
$session = Yii::$app->session;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Referrals - PreBit';
?>


<div class="top-dashboard no-margin-bottom-xs">
        <h2 class="title-general">REFERRALS </h2>
 </div>  

<div class="hidden">
    <!-- form search user -->
    <?php $form = ActiveForm::begin(['id' => 'searchuser']); ?>
        <?= $form->field($searchuser, 'username', ['template' => '<div class="form-search">{input}<button type="submit" aria-hidden="true"><i class="fa fa-search" aria-hidden="true"></i></button>{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Search username', 'class' => 'form-control', 'required' => 'required'])->label(false) ?>
    <?php ActiveForm::end(); ?>
    <!-- End / form form search user -->
</div>

<div class="bor-xs"><div class="row">
    <div class="col-sm-6">
        <div class="referrals-link referrals-box">
            <h4><?=Yii::$app->languages->getLanguage()['referrals_link']?></h4>
            <div class="input-group">
                <span class="input-group-btn hidden">
                    <button class="btn btn-default btn-copy" type="button" data-clipboard-action="copy" data-clipboard-target="#linkRegister"><?=Yii::$app->languages->getLanguage()['referrals_link']?></button>
                </span>
                
                <input class="form-control" id="linkRegister" type="text" value="<?=Yii::$app->params['url_file']?>register?u=<?=$this_user->username?>">
            </div><!-- /input-group -->
        </div><!--referrals-link-->


    </div><!-- col-md-6 -->
    <div class="col-sm-6">        
        <div class="end-send-help referrals-wrap referrals-box">
            <h4 class="title-end-send-help">Referral Statistics</h4>
            <div class="content-text">
                <p>Total members in your network <?=count($members_network)?></p>
                <p>Total F1 members <?=count($memberf1);?></p>
                <p>Deposit amount of your network last month <?= number_format($sumsh_network_lastmonth, 8, '.', '');?></p>
                <p>Deposit amount of your network this month <?= number_format($sumsh_network_thismonth, 8, '.', '');?></p>
                <p>Total Deposit amount of your network <?= number_format($sumsh_network, 8, '.', '');?></p>
            </div>
        </div><!--end-send-help-->

    </div><!-- col-md-6 -->
</div></div><!-- bor-xs -->
               

<?php if(!empty($referral_user_id)){?>
<div class="row end-send-help referrals-wrap">
    <div class="col-md-12">
        <h3 class="title-end-send-help title-general no-margin-bottom-xs"><?=Yii::$app->languages->getLanguage()['your_sposor']?></h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <table data-sortable class="table">
                        <thead>
                            <tr>
                                <!--<th data-sortable="false">Name</th> -->
                                <th data-sortable="false" class="tr-dark">Username</th>
                                <th data-sortable="false" class="tr-dark">Level</th>
                                <th data-sortable="false" class="tr-dark">Email</th>
                                <th data-sortable="false" class="tr-dark">Mobile</th>                                              
                                <!--<th data-sortable="false">SH</th>-->
                                <th data-sortable="false" class="tr-dark">Chat</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            <tr>
                                <!--<td><?=$referral_user_id->fullname?></td>-->
                                <td><?=$referral_user_id->username?></td>
                                <td>
                                    <?php 
                                    $rank = $referral_user_id->level;
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
                                <td><?=$referral_user_id->email?></td>
                                <td>(+<?=$referral_user_id->country->country_code;?>) <?=ltrim($referral_user_id->phone, '0');?></td>
                                <!--<td class="green-number">
                                    <strong>
                                        <?php if (!empty($referral_user_id->getTotalSh($referral_user_id->id))) {
                                        echo number_format($referral_user_id->getTotalSh($referral_user_id->id), 8, '.', '');
                                        }else{echo '0';}?>
                                    </strong>
                                </td>-->                                                
                                <td class="chat-table"><a class="btnchat" href="javascript:;" data-user="<?=Yii::$app->user->identity->id?>" data-id="<?=$referral_user_id->id?>"><img src="/images/chat-table.png" alt=""></a></td>
                            </tr>                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--end-send-help-->
<?php }?>

<div class="row end-send-help referrals-wrap">
    <div class="col-md-12">
        <h3 class="title-end-send-help title-general no-margin-bottom-xs"><?=Yii::$app->languages->getLanguage()['active_members']?>: <?=count($user_active)?></h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <table id="datatables-1" class="table table-striped">
                        <thead>
                            <tr>
                                <!--<th data-sortable="false">Name</th>-->
                                <th data-sortable="false" class="tr-dark">Username</th>
                                <th data-sortable="false" class="tr-dark">Level</th>
                                <th data-sortable="false" class="tr-dark">Email</th>
                                <th data-sortable="false" class="tr-dark">Mobile</th>   
                                <th data-sortable="false" class="tr-dark">Deposit this month</th>                                           
                                <th data-sortable="false" class="tr-dark">Deposit</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if(!empty($user_active)){
                            foreach ($user_active as $userid_active) {
                                $user = User::findOne($userid_active);
                            ?>
                            <tr>
                                <!--<td><?=$user->fullname?></td>-->
                                <td><a  href="<?=Yii::$app->params['site_url'];?>referrals/index/<?=$user->id;?>" data-lightbox="passport"><?=$user->username?></a></td>
                                <td>
                                    <?php 
                                    $rank = $user->level;
                                    switch ($rank)
                                    {
                                        case 0 :
                                            echo '';
                                            break;
                                        case 1:
                                            echo 'Level 1';
                                            break;
                                        case 2:
                                            echo 'Level 2';
                                            break;
                                        case 3:
                                            echo 'Level 3';
                                            break;
                                        case 4 :
                                            echo 'Level 4';
                                            break;
                                        case 5 :
                                            echo 'Level 5';
                                            break;
                                        case 6 :
                                            echo 'Level 6';
                                            break;
                                        case 7 :
                                            echo 'Level 7';
                                            break;
                                        case 8 :
                                            echo 'Level 8';
                                            break;
                                        default:
                                            echo '';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?=$user->email?></td>
                                <td>(+<?=$user->country->country_code;?>) <?=ltrim($user->phone, '0');?></td>
                                <td class="chat-table"><?php echo number_format($user->getTotalShthismonth($userid_active), 8, '.', ''); ?></td>
                                <td class="green-number"><strong><?php echo number_format($user->getTotalSh($userid_active), 8, '.', ''); ?></strong></td>                                                
                                
                            </tr>
                            <?php } }else{ ?>
                            <tr>
                                <td colspan="7">No user member</td>
                            </tr>
                            <?php }?>                                   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--end-send-help-->
<div class="row end-send-help referrals-wrap">
    <div class="col-md-12">
        <h3 class="title-end-send-help title-general no-margin-bottom-xs">Member(s) never Deposit: <?=count($user_noactive)?></h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <table id="datatables-2" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <!--<th data-sortable="false">Name</th>-->
                                <th data-sortable="false" class="tr-dark">Username</th>
                                <th data-sortable="false" class="tr-dark">Level</th>
                                <th data-sortable="false" class="tr-dark">Email</th>
                                <th data-sortable="false" class="tr-dark">Mobile</th>  
                                <th data-sortable="false" class="tr-dark">Deposit this month</th>                                              
                                <th data-sortable="false" class="tr-dark">Deposit</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if(!empty($user_noactive)){
                            foreach ($user_noactive as $userid_noactive) {
                                $user = User::findOne($userid_noactive);
                            ?>
                            <tr>
                                <!--<td><?=$user->fullname?></td>-->
                                <td><a  href="<?=Yii::$app->params['site_url'];?>referrals/index/<?=$user->id;?>" data-lightbox="passport"><?=$user->username?></a></td>
                                <td>
                                    <?php 
                                    $rank = $user->level;
                                    switch ($rank)
                                    {
                                        case 0 :
                                            echo '';
                                            break;
                                        case 1:
                                            echo 'Level 1';
                                            break;
                                        case 2:
                                            echo 'Level 2';
                                            break;
                                        case 3:
                                            echo 'Level 3';
                                            break;
                                        case 4 :
                                            echo 'Level 4';
                                            break;
                                        case 5 :
                                            echo 'Level 5';
                                            break;
                                        case 6 :
                                            echo 'Level 6';
                                            break;
                                        case 7 :
                                            echo 'Level 7';
                                            break;
                                        case 8 :
                                            echo 'Level 8';
                                            break;
                                        default:
                                            echo '';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?=$user->email?></td>
                                <td>(+<?=$user->country->country_code;?>) <?=ltrim($user->phone, '0');?></td>
                                <td class="chat-table"><?php echo number_format($user->getTotalShthismonth($userid_noactive), 8, '.', ''); ?></td>
                                <td class="green-number">
                                    <strong>
                                        <?php if (!empty($user->getTotalSh($userid_noactive))) {
                                        echo number_format($user->getTotalSh($userid_noactive), 8, '.', '');
                                        }else{echo '0';}?>
                                    </strong>
                                </td>                                                
                                
                            </tr>
                            <?php } }else{ ?>
                            <tr>
                                <td colspan="7">No user member</td>
                            </tr>
                            <?php }?>                                 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--end-send-help-->
<div class="row end-send-help referrals-wrap">
    <div class="col-md-12">
        <h3 class="title-end-send-help title-general no-margin-bottom-xs"><?=Yii::$app->languages->getLanguage()['inactive_members']?>: <?=count($user_current)?></h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <table id="datatables-3" class="table table-striped">
                        <thead>
                            <tr>
                                <!--<th data-sortable="false">Name</th>-->
                                <th data-sortable="false" class="tr-dark">Username</th>
                                <th data-sortable="false" class="tr-dark">Level</th>
                                <th data-sortable="false" class="tr-dark">Email</th>
                                <th data-sortable="false" class="tr-dark">Mobile</th>  
                                <th data-sortable="false" class="tr-dark">Deposit this month</th>    
                                <th data-sortable="false" class="tr-dark">Deposit</th> 
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if(!empty($user_current)){
                            foreach ($user_current as $userid_current) {
                                $user = User::findOne($userid_current);
                            ?>
                            <tr>
                                <!--<td><?=$user->fullname?></td>-->
                                <td><a  href="<?=Yii::$app->params['site_url'];?>referrals/index/<?=$user->id;?>" data-lightbox="passport"><?=$user->username?></a></td>
                                <td>
                                    <?php 
                                    $rank = $user->level;
                                    switch ($rank)
                                    {
                                        case 0 :
                                            echo '';
                                            break;
                                        case 1:
                                            echo 'Level 1';
                                            break;
                                        case 2:
                                            echo 'Level 2';
                                            break;
                                        case 3:
                                            echo 'Level 3';
                                            break;
                                        case 4 :
                                            echo 'Level 4';
                                            break;
                                        case 5 :
                                            echo 'Level 5';
                                            break;
                                        case 6 :
                                            echo 'Level 6';
                                            break;
                                        case 7 :
                                            echo 'Level 7';
                                            break;
                                        case 8 :
                                            echo 'Level 8';
                                            break;
                                        default:
                                            echo '';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?=$user->email?></td>
                                <td>(+<?=$user->country->country_code;?>) <?=ltrim($user->phone, '0');?></td> 
                                <td class="chat-table"><?php echo number_format($user->getTotalShthismonth($userid_current), 8, '.', ''); ?></td>
                                <td class="green-number">
                                    <strong>
                                        <?php if (!empty($user->getTotalSh($userid_noactive))) {
                                        echo number_format($user->getTotalSh($userid_noactive), 8, '.', '');
                                        }else{echo '0';}?>
                                    </strong>
                                </td>                                               
                            </tr>
                            <?php } }else{ ?>
                            <tr>
                                <td colspan="7">No user member</td>
                            </tr>
                            <?php }?>                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<aside id="sidebar_secondary" class="tabbed_sidebar ng-scope chat_sidebar">
    <div class="popup-head">
        <div class="popup-head-left pull-left">
            
            <h1 class="user_reciever_conversation"></h1>
        </div>
        <div class="popup-head-right pull-right">
            <button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button">
                <i class="glyphicon glyphicon-remove"></i>
            </button>
        </div>
    </div>

    <div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
        <div class="chat_box chat_box_content touchscroll chat_box_colors_a">
        </div>
    </div>

    <div class="chat_submit_box">
        <?= Html::beginForm(['/referrals/index'], 'POST', ['id' => 'chat-form']) ?>
            <div class="uk-input-group">
                <div class="">
                    <div class="file-atch"></div>
                    <input type="hidden" id="file_atch" name="file_atch">

                </div>
                <div class="gurdeep-chat-box">
                    <input id="userone" type="hidden" name="userone" value="">
                    <input id="usersecond" type="hidden" name="usersecond" value="">
                    <input id="lastdiv" type="hidden" name="lastdiv" value="">
                    <textarea type="text" placeholder="Type a message" id="submit_message" name="message" class="md-input"></textarea>
                </div>
            </div>
            <span style="vertical-align: sub;" class="uk-input-group-addon">
                <a href="javacript:;" id="fileAttach"><i class="fa fa-camera"></i></a>
                <input id="upload" type="file" style="display:none"/>
                <?= Html::submitButton('Send', ['class' => 'btn btn-block btn-success',]) ?>
            </span>
        <?= Html::endForm() ?>
    </div>
</aside>

<?php
if(count($user_active) > 10){
    echo $this->registerJs("
        $('#datatables-1').dataTable();
    ");
}
if(count($user_noactive) > 10){
    echo $this->registerJs("
        $('#datatables-2').dataTable();
    ");
}
if(count($user_current) > 10){
    echo $this->registerJs("
        $('#datatables-3').dataTable();
    ");
}
?>

<?=$this->registerJs("
$('#submit_message').keydown(function(event) {
    if (event.keyCode == 13) {
        $(this.form).submit()
        return false;
    }
})
$('#chat-form').submit(function() {

    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (response) {
           $('#submit_message').val('');
        }
    });

     return false;
});
"); ?>

<?= $this->registerJs("$(document).on('click', '#fileAttach', function (event){
        event.preventDefault();
        $('#upload').trigger('click');

});") ?>

<?=$this->registerJs("
$('#upload').change(function(){
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/messages/uploadfile', 
        //dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
            $('#file_atch').val(data);
            
            $('#chat-form').submit()
            return false;
           
        }
    });
})
");?>




