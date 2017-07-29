<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-boxs forgot-box col-md-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter your new password.</p>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= $form->field($model, 'password', ['template' => '<label for="email" class="fa fa-key" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['autofocus' => true, 'type'=>'password']) ?>
        <?= $form->field($model, 'password_repeat', ['template' => '<label for="email" class="fa fa-key" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['autofocus' => true, 'type'=>'password']) ?>

        <div class="form-group">
            <?= Html::submitButton('Reset password', ['class' => 'btn btn-primary form-control']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>    
        