<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LevelSetting */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php
        if(!empty($model->publish)){
            $act = 'close';
            $check = 'checked';
        }else{
            $act = 'opent';
            $check = '';
        }
    ?>

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>

    <?= $form->field($model, 'level', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Level </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Level', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'amount', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Amount </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Amount', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'child', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Childs </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Childs', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'child_level', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Child level </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Child level', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'child_2', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Childs 2 </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Childs 2', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'child_level_2', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Child level 2 </label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Child level 2', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'token', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Token gift monthly</label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Token for register', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'ticket', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Ticket gift monthly</label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Ticket for register', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'manager_bonus', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Floor manager bonus</label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Floor manager bonus', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>

    <?= $form->field($model, 'amount_sh', ['template' => '<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Amount sh permited</label><div class="col-sm-9">{input}{hint}{error}</div>'])->textInput(['placeholder' => 'Amount sh permited', 'class' => 'col-xs-10 col-sm-5', 'type'=>'number'])->label(false) ?>


    <div class="form-group field-cities-publish">
        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">Publish </label>
        <div class="col-sm-9">
            <label>
                <input type="checkbox" <?=$check?> act="<?=$act?>" data="country" value="<?php if(!empty($_GET['id'])){echo $_GET['id'];}?>" name="publish" class="ace ace-switch ace-switch-4 btn-empty" id="level-publish">
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

