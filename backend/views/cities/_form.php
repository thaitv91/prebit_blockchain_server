<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Cities */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>

    <?php
    if(!empty($model->publish)){
        $act = 'close';
        $check = 'checked';
    }else{
        $act = 'opent';
        $check = '';
    }
    ?>
    <?php 
        $listState=ArrayHelper::map($state,'id','name');
        $model->state_id = $model->isNewRecord ? $id : $model->state_id;
        echo $form->field($model, 'state_id', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">State name </label><div class="col-sm-9">{input}{hint}{error}</div>'])->dropDownList($listState, ['prompt' => 'Select state', 'class' => 'col-xs-10 col-sm-5'])->label(FALSE);
    ?>

    <?= $form->field($model, 'name', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">City name </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'City name', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>

    <?= $form->field($model, 'city_code', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">City code </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'City code', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>
    <div class="form-group field-cities-publish">
        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">Publish </label>
        <div class="col-sm-9">
            <label>
                <input type="checkbox" <?=$check?> act="<?=$act?>" data="city" value="<?=$_GET['id']?>" name="publish" class="ace ace-switch ace-switch-4 btn-empty" id="cities-publish">
                <span class="lbl"></span>
            </label>
        </div>
    </div>

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

<?= $this->registerJs('
$("input[id=cities-publish]").change(function(event, state) {
    var id = $(this).val();
    var type = $(this).attr("data");
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["states/publish"]) . '", 
        data: {id:id,type:type,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>
