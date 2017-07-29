<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\web\UploadedFile;
/* @var $this yii\web\View */
/* @var $model common\models\CharityProgram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-program-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'startday')->textInput(['maxlength' => true, 'id' => 'datepicker1', 'value' => !empty($model->startday) ? date('m/d/Y', $model->startday) : '']) ?>

    <?= $form->field($model, 'endday')->textInput(['maxlength' => true, 'id' => 'datepicker2', 'value' => !empty($model->endday) ? date('m/d/Y', $model->endday) : '']) ?>


    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?=$form->field($model,'file')->fileInput(); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
