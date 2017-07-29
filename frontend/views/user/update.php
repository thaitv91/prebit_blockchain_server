<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = 'Member Profile - PreBit';
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>PROFILE</h2>
        View and update your personal information on this page
    </div>                    
</div>                
                
<div class="row user-profile">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 profile-left">
        <div class="bg-white pad20">
            <span id="profile_picture" class="profile-picture">
                <?php  
                    if (empty($model->avatar)) {
                        echo '<img id="avatar" data-toggle="tooltip" style="cursor:pointer" class="editable img-responsive avarta" data-original-title="Change Your Avatar" alt="Change Your Avatar" src="';
                        echo Yii::$app->params['site_url'];
                        echo 'uploads/users/default-avatar.jpg"/>';
                    }else{
                        echo '<img id="avatar" data-toggle="tooltip" style="cursor:pointer" class="editable img-responsive avarta"  data-original-title="Change Your Avatar" alt="Change Your Avatar" src="';
                        echo Yii::$app->params['site_url'];
                        echo 'uploads/users/';
                        echo $model->avatar;
                        echo '"/>';
                    }

                ?>
                <input id="upload" type="file" style="display:none"/>
            </span>
            <div class="space-4"></div>
            <div class="row">
                <ul class="list-unstyled list-info">
                    <li>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <img src="/images/users/i-rank.png" class="img-responsive"> Rank: 
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <?php
                                $rank = Yii::$app->user->identity->level;
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
                        </div>
                    </li>
                    <li><div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <img src="/images/users/i-status.png" class="img-responsive"> Account Status:
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <?php
                                if ($model->publish == User::PUBLISH_ACTIVE) {
                                    echo '<span class="green-status">Verified</span>';
                                }else{
                                    echo '<span class="red-status">Unverified</span>';
                                }
                            ?>
                        </div>                                    
                    </li>
                    <li>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <img src="/images/users/i-phone.png" class="img-responsive"> Phone Verified: 
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <span class="red-status">Unverified</span>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <img src="/images/users/i-charity.png" class="img-responsive"> Charity Contribution:
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <?php if (!empty(Yii::$app->user->identity->charity)): ?>
                                 <?php
                                    for ($i=0; $i < Yii::$app->user->identity->charity;  $i++) {
                                        if(($i+1)<=5){
                                            echo '<img src="'.Yii::$app->params['site_url'].'images/heart-charity.png">'.'&nbsp;';
                                        }
                                        
                                    }
                                 ?>
                            <?php else: ?>
                            <?php echo ''; ?>
                            <?php endif ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="statics">
            <div class="title-statics">
                Statistics
            </div>
            <ul class="list-unstyled list-info">
                <li>
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <img src="<?=Yii::$app->params['site_url'];?>images/users/i-total-sh.png" class="img-responsive"> Total SH: 
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <?=number_format( $model->getTotalSh(Yii::$app->user->identity->id) , 8)?> BTC
                    </div>
                </li>
                <li><div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <img src="<?=Yii::$app->params['site_url'];?>images/users/i-total-gh.png" class="img-responsive"> Total GH:
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <?=number_format( $model->getUserGh(Yii::$app->user->identity->id) , 8)?> BTC
                    </div>                                    
                </li>
                <li>
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <img src="<?=Yii::$app->params['site_url'];?>images/users/i-direct-member.png" class="img-responsive"> Direct Members: 
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <?=$direct_members?>
                    </div>
                </li>
                <li>
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <img src="<?=Yii::$app->params['site_url'];?>images/users/i-active-member.png" class="img-responsive"> Active Members:
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <?=$user_active?>
                    </div>
                </li>
            </ul>
        </div><!--statics-->
    </div><!--col-lg-3-->
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-right">
        <ul id="account-tab" class="nav nav-tabs">
            <li class="active">
                <a href="#account-info" data-toggle="tab">Account Info</a>
            </li>
            <li>
                <a href="#verification" data-toggle="tab">Verification Documents</a>
            </li>
            <li>
                <a href="#change-pass" data-toggle="tab">Change Password</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="account-info">
                <h4 class="title-acinfo display_none">Level Status</h4>
                
                <div class="process-bar display_none">
                    <div class="title-process">
                        Current Points: <b>80</b>
                    </div>
                    <div class="content-process">
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <img src="/images/rank/i-bronze.png" class="img-responsive">
                        </div>
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">                                            
                            <div class="progress progress-sm no-rounded">
                                <span class="level-process before-p">Bronze</span>
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="option-chart">80/100</span>
                                </div>
                                <span class="level-process level-process after-p">Silver</span>
                            </div>
                            <label>Sed pid elementum turpis magnis</label>                                            
                        </div>
                        
                    </div><!--content-process-->
                </div><!--process-bar-->
                
                <div class="account-infomation">
                    <div class="pmb-block ng-scope">
                        <div class="pmbb-header">
                            <h4>Account Infomation</h4>
                            <div class="btn-edit">
                                <a href="" title=""><img src="/images/i-edit.png" class="img-responsive"> Edit</a>
                            </div>                                         
                        </div>
                        <div class="pmbb-body p-l-30">
                           <?= $this->render('_form', [
						        'model' => $model,
						    ]) ?>                                           
                        </div>
                    </div>
                </div><!--account-infomation-->
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="verification">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="item-pass">
                        <h5>Passport</h5>
                        <div class="info-card">
                            <span id="passport_picture" class="profile-picture">
                                <?php if (!empty($model->passport)): ?>
                                    <a class="passport-call" href="<?=Yii::$app->params['site_url'];?>uploads/passport/<?=$model->passport;?>" data-lightbox="passport"><img id="passport" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->passport;?>" src="<?=Yii::$app->params['site_url'];?>uploads/passport/<?=$model->passport;?>" /></a>  
                                <?php endif ?>                                                              
                            </span>
                            <input id="upload_passport" type="file"  style="display:none"/>
                        </div><!--info-card-->
                        <button id="btn-passport" class="btn btn-upload">UPLOAD</button>
                    </div>
                </div><!--col-lg-4-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="item-pass">
                        <h5>Identification Card</h5>
                        <div class="info-card">
                            <span id="identification_picture" class="profile-picture">
                                <?php if (!empty($model->identification)): ?>
                                    <a class="identification-call" href="<?=Yii::$app->params['site_url'];?>uploads/identification/<?=$model->identification;?>" data-lightbox="identification"><img id="identification" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->identification;?>" src="<?=Yii::$app->params['site_url'];?>uploads/identification/<?=$model->identification;?>" /></a>
                                <?php endif ?>                                
                            </span>
                            <input id="upload_identification" type="file"  style="display:none"/>
                        </div><!--info-card-->
                        <button id="btn-identification" class="btn btn-upload">UPLOAD</button>
                    </div>
                </div><!--col-lg-4-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="item-pass">
                        <h5>Selfie with Bitway</h5>
                        <div class="info-card">
                            <span id="selfie_picture" class="profile-picture">
                                <?php if (!empty($model->identification)): ?>
                                    <a class="selfie-call" href="<?=Yii::$app->params['site_url'];?>uploads/selfie/<?=$model->selfie;?>" data-lightbox="selfie"><img id="selfie" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->selfie;?>" src="<?=Yii::$app->params['site_url'];?>uploads/selfie/<?=$model->selfie;?>" /></a>
                                <?php endif ?>
                            </span>
                            <input id="upload_selfie" type="file"  style="display:none"/>
                        </div><!--info-card-->
                        <button id="btn-selfie" class="btn btn-upload">UPLOAD</button>
                    </div>
                </div><!--col-lg-4-->
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="change-pass">
                <form class="form-horizontal">
                    <p class="bg-success pass_change"></p>
                    <div class="form-group Current_Password">
                        <label for="inputPassword3" class="col-sm-4 control-label">Current Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="current_pass" placeholder="">
                            <p class="current_pass red-p"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">New Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="new_pass_1" placeholder="">
                            <p class="new_pass_1 red-p"></p>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0">
                        <label for="inputPassword3" class="col-sm-4 control-label">Confirm New Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="new_pass_2" placeholder="">
                            <p class="new_pass_2 red-p"></p>
                            <p class="pass_khop red-p"></p>
                        </div>
                    </div>
                    
                     <div id="otp-pass" class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Enter your OTP:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pass_otp" placeholder="">
                            <p class="ma-otp red-p"></p>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-sm-12">
                        <button type="button" id="save_pass" class="btn btn-success">SAVE CHANGE</button>
                        <button type="button" id="confirm_pass" class="btn btn-success">CONFIRM CHANGE</button>
                        <button type="submit" class="btn btn-default">CANCEL</button>
                    </div>
                </form>
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->
    </div><!--col-lg-9-->
</div><!--user-profile-->

<?=$this->registerJs("
  $( function() {
    $( '#datepickernew' ).datepicker({
beforeShow: function (input, inst) {
         var offset = $(input).offset();
         var height = $(input).height();
         window.setTimeout(function () {
             inst.dpDiv.css({ top: (offset.top + height + 4) + 'px', left: offset.left + 'px' })
         }, 1);
     },
	  dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
	  yearRange:'1920:2016'
    });
  } );

//text editable
$('#save_pass').click(function(){
    
    var current_pass = $('#current_pass').val();
    var new_pass_1 = $('#new_pass_1').val();
    var new_pass_2 = $('#new_pass_2').val();
    var pass_otp = $('#pass_otp').val();

    if(!current_pass){
        $('.current_pass').html('Please enter current password !');
        $('.current_pass').focus();
        return false;
    } 
    if ( current_pass.length < 6 ){
       $('.current_pass').html('This field must be more than 6 characters !');
        $('.current_pass').focus();
        return false;
    } else {
        $('.current_pass').html('');
    }
    if(!new_pass_1){
        $('.new_pass_1').html('Please enter your New Password !');
        $('.new_pass_1').focus();
        return false;
    }if ( new_pass_1.length < 6 ){
       $('.new_pass_1').html('This field must be more than 6 characters !');
        $('.new_pass_1').focus();
        return false;
    } else{
        $('.new_pass_1').html('');
    }
    if(!new_pass_2){
        $('.new_pass_2').html('Please confirm your New Password');
        $('.new_pass_2').focus();
        return false;
    }if ( new_pass_2.length < 6 ){
       $('.new_pass_2').html('This field must be more than 6 characters');
        $('.new_pass_2').focus();
        return false;
    } else{
        $('.new_pass_2').html('');
    }
    
    if (new_pass_1 !=  new_pass_2) {
        $('.pass_khop').html('Your new password and confirmation new password do not match');
        return false;
    }else{
        $('.pass_khop').html('');
    }
    if (new_pass_1 ==  current_pass) {
        $('.pass_khop').html('New password must be different from old password');
        return false;
    }else{
        $('.pass_khop').html('');
    }
    $.ajax({
        type: \"POST\", 
        url:'/user/checkpass', 
        data: {current_pass:current_pass},
        success: function (data) {
            if (data == false){
                $('.current_pass').html('Current Password Wrong !');
                return false;
            }else{
                $('.current_pass').html('');
            }
            if (data == true){
                $('#otp-pass').css('display', 'block');
                alert('A one-time password (OTP) has been sent to your email. Please check and enter it into the box below to continue.');
                $('#save_pass').css('display', 'none');
                $('#confirm_pass').css('display', 'inline-block');
            }   
        }
    });
});

$('#confirm_pass').click(function(){
    var current_pass = $('#current_pass').val();
    var new_pass_1 = $('#new_pass_1').val();
    var new_pass_2 = $('#new_pass_2').val();
    var pass_otp = $('#pass_otp').val();
    if(!new_pass_1){
        $('.new_pass_1').html('Please input new password !');
        $('.new_pass_1').focus();
        return false;
    }if ( new_pass_1.length < 8 ){
       $('.new_pass_1').html('This field must be more than 8 characters !');
        $('.new_pass_1').focus();
        return false;
    } else{
        $('.new_pass_1').html('');
    }
    if(!new_pass_2){
        $('.new_pass_2').html('Please input new password again !');
        $('.new_pass_2').focus();
        return false;
    }if ( new_pass_2.length < 8 ){
       $('.new_pass_2').html('This field must be more than 8 characters');
        $('.new_pass_2').focus();
        return false;
    } else{
        $('.new_pass_2').html('');
    }
    
    if (new_pass_1 !=  new_pass_2) {
        $('.pass_khop').html('ko khop');
        return false;
    }else{
        $('.pass_khop').html('');
    }
    $.ajax({
        type: \"POST\", 
        url:'/user/infoupdate', 
        data: {current_pass:current_pass,new_pass_1:new_pass_1,new_pass_2:new_pass_2, pass_otp:pass_otp},
        success: function (data) {            
            if (data == false){
                $('.ma-otp').html('Wrong OTP. Please try again!');
                
            }else{
                alert('Your password has been changed. Please log-in again using your new password.');
                location.reload(true);
            }    
        }
    });    
});


$('#upload').change(function(){
    var id = '".Yii::$app->user->identity->id."';
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/user/updateavatar/'+id, // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            location.reload(true);
            var img = php_script_response.replace('\"', ''); ;
            $('#profile_picture').html('<img id=\"avatar\" style=\"cursor:pointer\" class=\"editable img-responsive avarta\" src=\"".Yii::$app->params['site_url']."uploads/users/'+img+'\" />');
        }
    });
})


$('#upload_passport').change(function(){
    var id = '".Yii::$app->user->identity->id."';
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/user/updatepassport/'+id, // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            var img = php_script_response.replace('\"', ''); ;
            $('#passport_picture').html('<img id=\"passport\" style=\"cursor:pointer\" class=\"editable img-responsive avarta\" src=\"".Yii::$app->params['site_url']."uploads/passport/'+img+'\" />');
        }
    });
})

$('#upload_identification').change(function(){
    var id = '".Yii::$app->user->identity->id."';
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/user/updateidentification/'+id, // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            var img = php_script_response.replace('\"', ''); ;
            $('#identification_picture').html('<img id=\"identification\" style=\"cursor:pointer\" class=\"editable img-responsive avarta\" src=\"".Yii::$app->params['site_url']."uploads/identification/'+img+'\" />');
        }
    });
})

$('#upload_selfie').change(function(){
    var id = '".Yii::$app->user->identity->id."';
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/user/updateselfie/'+id, // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            var img = php_script_response.replace('\"', ''); ;
            $('#selfie_picture').html('<img id=\"selfie\" style=\"cursor:pointer\" class=\"editable img-responsive avarta\" src=\"".Yii::$app->params['site_url']."uploads/selfie/'+img+'\" />');
        }
    });
})
");?>


<?= $this->registerJs("$(document).on('click', '#avatar', function (event){
        event.preventDefault();
        $('#upload').trigger('click');

});") ?>
<?= $this->registerJs("$(document).on('click', '#btn-passport', function (event){
        event.preventDefault();
        $('#upload_passport').trigger('click');

});") ?>
<?= $this->registerJs("$(document).on('click', '#btn-identification', function (event){
        event.preventDefault();
        $('#upload_identification').trigger('click');

});") ?>
<?= $this->registerJs("$(document).on('click', '#btn-selfie', function (event){
        event.preventDefault();
        $('#upload_selfie').trigger('click');

});") ?>
<script src="<?=Yii::$app->params['site_url'] ?>/libs/light-box/lightbox-plus-jquery.min.js"></script>