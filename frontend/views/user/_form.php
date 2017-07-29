<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="update-profile-info">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
        <?= $form->field($model, 'fullname', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Full Name </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Full Name', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>

        <?php echo $form->field($model, 'sex', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Gender </label><div class="col-sm-9">{input}{hint}{error}</div>'])->dropDownList([User::MALE => 'Male', User::FEMALE => 'Female']); ?>

        <?= $form->field($model, 'birthday', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date of Birth </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => '', 'id' => 'datepickernew', 'class' => 'col-xs-10 col-sm-5 form-control', 'value' => !empty($model->birthday) ? date('d/m/Y', $model->birthday) : ''])->label(false) ?>
        
        <?= $form->field($model, 'email', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email </label><fieldset disabled><div class="col-sm-6">{input}{hint}{error}</div><span class="line-h">Contact support to change your email.</span></fieldset>'])->textInput(['maxlength' => true, 'placeholder' => 'Address', 'class' => 'col-xs-10 col-sm-5 form-control', 'id'=>'disabledInput'])->label(false) ?>

        <?= $form->field($model, 'phone', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mobile Number </label><div class="col-sm-9"><div class="input-group"><span class="input-group-addon">(+'.$model->country->country_code.')</span> {input}{hint}{error}</div></div>'])->textInput(['maxlength' => true, 'placeholder' => 'Phone', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>

        <?= $form->field($model, 'passport_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Passport/ID Number </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Passport', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>

        <?= $form->field($model, 'address', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Address', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>
        
        <?php echo $form->field($model, 'country_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Country </label><div class="col-sm-9">{input}{hint}{error}</div>'])->dropDownList($model->listCountry, ['prompt'=>'Choose...']); ?>

        <?= $form->field($model, 'state_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">State </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'State', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>

        <?= $form->field($model, 'city_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">City </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'City', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>     

        <?= $form->field($model, 'postcode', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Postcode </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Postcode', 'class' => 'col-xs-10 col-sm-5 form-control'])->label(false) ?>
        

        <?= Html::submitButton('SAVE CHANGES', ['class'=> 'btn btn-primary']) ;?>
        <?php echo Html::a('CANCEL', '/user/view/', ['class'=>'btn btn-reset']) ?>

    <?php ActiveForm::end(); ?>
</div>

