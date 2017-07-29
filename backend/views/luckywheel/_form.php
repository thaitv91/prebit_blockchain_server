<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LuckyWheel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lucky-wheel-form">

    <?php 
    if(!$model->isNewRecord){ 
        $startdate =  date('d-m-Y', $model->start); 
        $finishdate =  date('d-m-Y', $model->finish);
    } else {
        $startdate = ''; 
        $finishdate = '';
    } ?>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name </label><div class="col-md-6 col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Name', 'class' => 'form-control', 'type'=>'text'])->label(false) ?>

    <?= $form->field($model, 'start', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Start </label><div class="col-md-6 col-sm-9"><div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}</div>'])->textInput(['placeholder' => 'Name', 'class' => 'form-control date-picker-future', 'data-date-format'=>'dd-mm-yyyy', 'type'=>'text', 'value'=> $startdate])->label(false) ?>

    <?= $form->field($model, 'finish', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Finish </label><div class="col-md-6 col-sm-9"><div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}</div>'])->textInput(['placeholder' => 'Name', 'class' => 'form-control date-picker-future', 'data-date-format'=>'dd-mm-yyyy', 'type'=>'text', 'value' => $finishdate])->label(false) ?>

    <div class="form-group">
        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">Gift for lucky wheel </label>
        <div class="col-md-6 col-sm-9">
            <select multiple="multiple" size="10" name="listgift[]" id="duallist">
                <?php
                foreach ($listgift as $key => $value) {
                    if (in_array($key, $listgiftSelected)) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
                ?>
            </select>
        </div>    
    </div>

    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i> Create' : '<i class="ace-icon fa fa-check bigger-110"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="hr hr-24"></div>

    <?php ActiveForm::end(); ?>

</div>

<?=$this->registerJs("
    var demo1 = $('select[name=\"listgift[]\"]').bootstrapDualListbox({infoTextFiltered: '<span class=\"label label-purple label-lg\">Filtered</span>'});
")?>
