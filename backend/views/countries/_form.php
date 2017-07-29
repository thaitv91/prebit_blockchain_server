<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>


<!-- PAGE CONTENT BEGINS -->
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
    <?= $form->field($model, 'name', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Country name </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Country name', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>
    <?= $form->field($model, 'country_code', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Country code </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Country code', 'class' => 'col-xs-10 col-sm-5'])->label(false) ?>
    <div class="form-group field-cities-publish">
        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">Publish </label>
        <div class="col-sm-9">
            <label>
                <input type="checkbox" <?=$check?> act="<?=$act?>" data="country"  name="publish" class="ace ace-switch ace-switch-4 btn-empty" id="cities-publish">
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
        url:"' . Yii::$app->urlManager->createUrl(["countries/publish"]) . '", 
        data: {id:id,type:type,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>