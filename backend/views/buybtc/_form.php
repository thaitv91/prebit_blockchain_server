<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BuyBtc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buy-btc-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'country_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Country </label><div class="col-sm-9">{input}{hint}{error}</div>'])->dropDownList($model->listCountry, ['prompt' => 'Select country', 'class' => 'col-xs-10 col-sm-5'])->label(FALSE); ?>

	<?= $form->field($model, 'address', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Address', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>

    <div class="space-4"></div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i> Create' : '<i class="ace-icon fa fa-check bigger-110"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            &nbsp; &nbsp; &nbsp;
            <?php 
            if($model->isNewRecord){
                echo '<button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>';
            }
            ?>
            
        </div>
    </div>
    <div class="hr hr-24"></div>

    <?php ActiveForm::end(); ?>

</div>
