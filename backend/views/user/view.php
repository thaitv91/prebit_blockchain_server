<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">

    <div class="page-header">
        <h1>
            User Profile

            <!-- <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                3 styles with inline editable feature
            </small> -->
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div>
                <div id="user-profile-1" class="user-profile row">
                    <div class="col-xs-12 col-sm-3 center">
                        <div>
                            <span id="profile_picture" class="profile-picture">
                                <img id="avatar" style="cursor:pointer" class="editable img-responsive" alt="Alex's Avatar" src="<?= Yii::$app->params['site_url_front_end']?>uploads/users/<?=$model->avatar;?>" />
                            </span>
                            <input id="upload" type="file" style="display:none"/>

                            <div class="space-4"></div>

                            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-circle light-green"></i>
                                        <span class="white"><?=$model->username;?></span>
                                    </a>

                                    <ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
                                        <li class="dropdown-header"> Change Status </li>

                                        <li>
                                            <a href="#">
                                                <i class="ace-icon fa fa-circle green"></i>
                                                <span class="green">Available</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ace-icon fa fa-circle red"></i>
                                                <span class="red">Busy</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ace-icon fa fa-circle grey"></i>
                                                <span class="grey">Invisible</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="space-6"></div>

                        <div class="profile-contact-info">
                            <div class="profile-contact-links align-left">
                                <a href="#" class="btn btn-link">
                                    <i class="ace-icon fa fa-share-square-o bigger-120 green"></i>
                                    Show count info
                                </a>

                                <a href="#" class="btn btn-link">
                                    <i class="ace-icon fa fa-envelope bigger-120 pink"></i>
                                    Send a message
                                </a>
                            </div>

                            <!-- <div class="space-6"></div>

                            <div class="profile-social-links align-center">
                                <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                                    <i class="middle ace-icon fa fa-facebook-square fa-2x blue"></i>
                                </a>

                                <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                                    <i class="middle ace-icon fa fa-twitter-square fa-2x light-blue"></i>
                                </a>

                                <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                                    <i class="middle ace-icon fa fa-pinterest-square fa-2x red"></i>
                                </a>
                            </div> -->
                        </div>

                        <div class="hr hr12 dotted"></div>
                        <div class="clearfix">
                            <div class="grid2">
                                <span class="bigger-175 blue"><?=number_format($balance_btc, 8)?></span>
                                <br />
                                PREBIT WALLET
                            </div>

                            <div class="grid2">
                                <span class="bigger-175 blue"><?=number_format($model->wallet, 8)?></span>
                                <br />
                                GH BALANCE
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="grid2">
                                <span class="bigger-175 blue"><?=number_format($model->manager_bonus + $model->referral_bonus , 8)?></span>
                                <br />
                                BONUS BALANCE
                            </div>

                            <div class="grid2">
                                <span class="bigger-175 blue"><?=$model->token?></span>
                                <br />
                                FEE BALANCE
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="grid2">
                                <span class="bigger-175 blue"><?=$model->level?></span>
                                <br />
                                Level
                            </div>

                            <div class="grid2">
                                <span class="bigger-175 blue"><?=count($model->getTotaldownlinef1($model->id))?></span>
                                <br />
                                Downline member
                            </div>
                        </div>

                        <div class="hr hr16 dotted"></div>
                    </div>

                    <div class="col-xs-12 col-sm-9">
                    
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Referral user </div>

                                <div class="profile-info-value">
                                    <span id="referralusername">
                                        <?php 
                                        if(!empty($model->referral_user_id)){
                                            $user_referral = $model->getUserParrent($model->referral_user_id);
                                            if(!empty($user_referral)){
                                                //var_dump($user_referral['username']); 
                                                echo $user_referral['username'];
                                            }else{
                                                echo 'Empty';
                                            }
                                            
                                        }else{
                                            echo 'Empty';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Full name </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="username"><?=$model->fullname;?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="email"><?=$model->email;?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Gender </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="sex">
                                    <?php
                                    if($model->sex != 1){
                                        echo 'Female';
                                    }else{echo 'Male';}
                                    ?>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Country </div>
                
                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span class="editable" id="country"><?php empty($model->country->name) ? '' : $model->country->name?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> State </div>
                
                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span class="editable" id="state"><?php if(!empty($model->state_id)){ echo $model->state_id;}else{echo '';} ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> City </div>
                
                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span class="editable" id="city"><?php if(!empty($model->city_id)){ echo $model->city_id;}else{echo '';} ?></span>
                                </div>
                            </div>      

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Address </div>

                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span class="editable" id="address"><?=$model->address?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Birthday </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="birthdate"><?php if(!empty($model->birthday)){ echo date('d/m/Y', $model->birthday);}else{echo '';} ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Phone </div>

                                <div class="profile-info-value">
                                    (+<?=$model->country->country_code;?>) <span class="editable" id="phone"><?=$model->phone;?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> BTC address </div>

                                <div class="profile-info-value">
                                    <span><?=$address_btc?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Post code </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="postcode"><?=$model->postcode;?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Passport/ID Number </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="passportid"><?=$model->passport_id;?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Register at </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="passportid"><?=date('H:i d/m/Y', $model->created_at);?></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-20"></div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <?php 
                                if ($model['publish'] == User::PUBLISH_ACTIVE){
                                    $check = 'checked="checked"';
                                    $act = 'close';
                                } else {
                                    $check = '';
                                    $act = 'opent';
                                }
                            ?>
                            <p><label class="lable-control">Verify</label></p>
                            
                            <input name="publish" class="ace ace-switch ace-switch-4 btn-empty" act='<?=$act?>' <?=$check?> type="checkbox" value='<?=$model->id?>' /><span class="lbl"></span>
                        </div>

                        <div class="space-20"></div>

                        <div class="">
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                <div class="item-pass">
                                    <h5>Passport</h5>
                                    <div class="info-card">
                                        <span id="passport_picture" class="profile-picture">
                                            <?php 
                                            if(!empty($model->passport)){
                                            ?>
                                            <a class="passport-call" href="<?=Yii::$app->params['site_url_front_end'];?>uploads/passport/<?=$model->passport;?>" data-lightbox="passport"><img id="passport" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->passport;?>" src="<?=Yii::$app->params['site_url_front_end'];?>uploads/passport/<?=$model->passport;?>" /></a>  
                                            <?php
                                            }else{
                                            ?>
                                            <a class="passport-call" href="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" data-lightbox="passport"><img id="passport" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->passport;?>" src="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" /></a>  
                                            <?php
                                            }
                                            ?>                           
                                        </span>
                                    </div><!--info-card-->
                                </div>
                            </div><!--col-lg-4-->
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                <div class="item-pass">
                                    <h5>Identification Card</h5>
                                    <div class="info-card">
                                        <span id="identification_picture" class="profile-picture">
                                            <?php 
                                            if(!empty($model->identification)){
                                            ?>
                                            <a class="identification-call" href="<?=Yii::$app->params['site_url_front_end'];?>uploads/identification/<?=$model->identification;?>" data-lightbox="identification"><img id="identification" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->identification;?>" src="<?=Yii::$app->params['site_url_front_end'];?>uploads/identification/<?=$model->identification;?>" /></a>
                                            <?php
                                            }else{
                                            ?>
                                            <a class="identification-call" href="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" data-lightbox="identification"><img id="identification" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->identification;?>" src="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" /></a>
                                            <?php
                                            }
                                            ?>   
                                        </span>
                                    </div><!--info-card-->
                                </div>
                            </div><!--col-lg-4-->
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                <div class="item-pass">
                                    <h5>Selfie with Bitway</h5>
                                    <div class="info-card">
                                        <span id="selfie_picture" class="profile-picture">
                                            <?php 
                                            if(!empty($model->selfie)){
                                            ?>
                                            <a class="selfie-call" href="<?=Yii::$app->params['site_url_front_end'];?>uploads/selfie/<?=$model->selfie;?>" data-lightbox="selfie"><img id="selfie" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->selfie;?>" src="<?=Yii::$app->params['site_url_front_end'];?>uploads/selfie/<?=$model->selfie;?>" /></a>
                                            <?php
                                            }else{
                                            ?>
                                            <a class="selfie-call" href="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" data-lightbox="identification"><img id="selfie" style="cursor:pointer" class="editable img-responsive avarta" alt="<?=$model->selfie;?>" src="<?=Yii::$app->params['site_url'];?>images/no_thumbnails.jpg" /></a>
                                            <?php
                                            }
                                            ?>   
                                        </span>
                                    </div><!--info-card-->
                                </div>
                            </div><!--col-lg-4-->
                            <div class="clear-fix"></div>
                        </div>
                        <div class="clear-fix"></div>                   
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="space-20"></div>

                        

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4>Downline member</h4>
                            <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                            <?= $form->field($userfilter, 'status', ['template' => '<label>Status : </label>{input}{hint}{error}'])->dropDownList($userfilter->listStatus, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'publish', ['template' => '<label>Publish : </label>{input}{hint}{error}'])->dropDownList($userfilter->listPublish, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'shstatus', ['template' => '<label>SH status : </label>{input}{hint}{error}'])->dropDownList($userfilter->listShstatus, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'level', ['template' => '<label>Level : </label>{input}{hint}{error}'])->dropDownList($userfilter->listLevel, ['class'=>'form-control'])->label(false); ?>
                            <?= $form->field($userfilter, 'dayfrom', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                            <?= $form->field($userfilter, 'dayto', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                            <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                            <?php ActiveForm::end(); ?>
                            <h2></h2>
                        </div>


                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4>Send Help</h4>
                            <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                            <?= $form->field($userfilter, 'dayfromsh', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                            <?= $form->field($userfilter, 'daytosh', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                            <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                            <?php ActiveForm::end(); ?>
                            <h2></h2>
                        </div>

                        

                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'showFooter'=>TRUE,
                        'footerRowOptions'=>['style'=>'font-weight:bold;', 'class'=>'total_amountsh text-right'],
                        'columns' => [
                            [
                                'attribute' => 'username',
                                'format' =>'raw',
                                'label' => 'User name',
                                'value' => function($data) {
                                    return Html::a($data['username'], '/user/view/'.$data['id'], ['title' => Yii::t('app', 'View'),'data-pjax' => '0', ]);
                                }
                            ],
                            [
                                'attribute' => 'level',
                                'label' => 'Level',

                            ],
                            [
                                'attribute' => '',
                                'label' => 'Total downline member',
                                'value' => function($data) {
                                        return count($data->getTotaldownlinef1($data['id']));
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'Bitcoin Address',
                                'value' => function($data) {
                                    return $data->getAddressbitcoin($data['username']);
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'SH total amount',
                                'headerOptions' => ['class' => 'text-right'],
                                'contentOptions' => ['class' => 'shamount text-right'],
                                'value' => function($data, $sh_dateto, $sh_datefrom) use ($sh_dateto, $sh_datefrom) {
                                    if(!empty($sh_dateto)){
                                        $sumamount = $data->getSumamountshdate($data['id'], $sh_datefrom, $sh_dateto);
                                        return $sumamount;
                                    } else {
                                        if(!empty($data->getTotalSh($data['id']))){
                                            return $data->getTotalSh($data['id']);
                                        }else{
                                            return 0;
                                        }
                                    }
                                }
                            ],
                        ],
                        //'showPageSummary' => true,
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                    ]); ?>
                        </div>
                    </div>    
                </div>
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<?php
    $listState=ArrayHelper::map($countries,'id','name');
    $string = ''; //data list countries
    $string2 =''; //data list states
    $string3 =''; //
    $string4 =''; //
    $string5 =''; //data list cities
    foreach ($listState as $key => $value) {
        if(!empty($string)){
            $string .= ',"'.$key.'":"'.$value.'"';
        }else{
            $string .= '"'.$key.'":"'.$value.'"';
        }
    }
    foreach ($listState as $key => $value) {
        $string3 ='';
        $string2 .= 'states["'.$key.'"] = [];';
        $states = $model->getStatefromcountry($key);
        foreach ($states as $key => $value) {
            if(!empty($string3)){
                $string3 .= ',"'.$value->id.'":"'.$value->name.'"';
            }else{
                $string3 .= '"'.$value->id.'":"'.$value->name.'"';
            }
            $cities = $model->getCitiesfromstate($value->id);
            $string4 ='';
            $string5 .= 'cities["'.$value->id.'"] = [];';
            foreach ($cities as $key => $val) {
                if(!empty($string4)){
                    $string4 .= ',"'.$val->id.'":"'.$val->name.'"';
                }else{
                    $string4 .= '"'.$val->id.'":"'.$val->name.'"';
                }
            }
            $string5 .= '$.each({'.$string4.'},function(k,v){cities["'.$value->id.'"].push({id: k, text: v})});';
        }
        $string2 .= '$.each({'.$string3.'},function(k,v){states["'.$key.'"].push({id: k, text: v})});';
    }
?>
<?php
if(!empty($model->country)){
    $country_id = $model->country->id;
    $country_name = $model->country->name;
}else{
    $country_id = 'null';
    $country_name = 'null';
}
?>
<?=$this->registerJs("

//editables on first profile page
$.fn.editable.defaults.mode = 'inline';
$.fn.editableform.loading = \"<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>\";
$.fn.editableform.buttons = '<button type=\"submit\" class=\"btn btn-info editable-submit\"><i class=\"ace-icon fa fa-check\"></i></button>'+
                            '<button type=\"button\" class=\"btn editable-cancel\"><i class=\"ace-icon fa fa-times\"></i></button>';    

//editables 

//text editable
$('#username').editable({
    type: 'text',
    name: 'username',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'fullname';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});


var sex =[];
sex[\"CA\"] = [];
$.each([\"Male\", \"Female\"] , function(k, v){
    sex[\"CA\"].push({id: k, text: v});
});
var currentValue = \"CA\";
$('#sex').editable({
    type: 'select2',
    value : 'CA',
    source: sex[currentValue],
    select2: {
        'width': 140
    },
    success : function(k, val)
    {
        var id = ".$_GET['id'].";
        var type = 'sex';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});


//*******select2 editable************//
var countries = [];
$.each({".$string."}, function(k, v) {
    countries.push({id: k, text: v});
});



var currentValue = \"2\";
$('#country').editable({
    type: 'select2',
    value : '".$country_id."',
    //onblur:'ignore',
    source: countries,
    select2: {
        'width': 140
    },      
    success: function(response, newValue) {
        var id = ".$_GET['id'].";
        var type = 'country_id';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:newValue}, 
            success: function (data) {
            }
        });

        if(currentValue == newValue) return;
        currentValue = newValue;
    }
});

$('#state').editable({
    type: 'text',
    name: 'state',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'state_id';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});

$('#city').editable({
    type: 'text',
    name: 'city',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'city_id';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});




//custom date editable
$('#birthdate').editable({
    type: 'adate',
    date: {
        //datepicker plugin options
        format: 'yyyy/mm/dd',
        viewformat: 'yyyy/mm/dd',
        weekStart: 1
    },
    success : function(k, val)
    {
        var id = ".$_GET['id'].";
        var type = 'birthday';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
})

$('#email').editable({
    type: 'text',
    name: 'address',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'email';
        $.ajax({
            type: \"POST\", 
            url:'/user/updateemail', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
                if(data){
                    alert('This email exists in the system');
                    location.reload();
                }
            }
        });
    }
});

$('#address').editable({
    type: 'text',
    name: 'address',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'address';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});

$('#phone').editable({
    type: 'text',
    name: 'phone',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'phone';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});


$('#postcode').editable({
    type: 'text',
    name: 'postcode',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'postcode';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});


$('#passportid').editable({
    type: 'text',
    name: 'passport_id',
    success : function(k, val)
    {
        if($.trim(val) == ''){
            return 'This field is required';
            return false;
        }
        var id = ".$_GET['id'].";
        var type = 'passport_id';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:val}, 
            success: function (data) {
            }
        });
    }
});

$('#description').editable({
    mode: 'inline',
    type: 'wysiwyg',
    name : 'description',

    wysiwyg : {
        //css : {'max-width':'300px'}
    },
    success: function(response, newValue) {
        var id = ".$_GET['id'].";
        var type = 'description';
        $.ajax({
            type: \"POST\", 
            url:'/user/infoupdate', 
            data: {id:id,type:type,value:newValue}, 
            success: function (data) {
            }
        });
    }
});


$('#profile-feed-1').ace_scroll({
    height: '250px',
    mouseWheelLock: true,
    alwaysVisible : true
});


$('#upload').change(function(){
    var id = '".$_GET['id']."';
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
            var img = php_script_response.replace('\"', ''); ;
            $('#profile_picture').html('<img id=\"avatar\" style=\"cursor:pointer\" class=\"editable img-responsive\" src=\"".Yii::$app->params['site_url_front_end']."uploads/users/'+img+'\" />');
        }
    });
})
");?>


<?= $this->registerJs("$(document).on('click', '#avatar', function (event){
        event.preventDefault();
        $('#upload').trigger('click');

});") ?>


<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["user/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>

<?=$this->registerJs('
    var sum = 0;
    $(".shamount").each(function(){
        sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
    });
    $(".total_amountsh").find("td:last").html("Total sh amount: "+sum);
')?>


