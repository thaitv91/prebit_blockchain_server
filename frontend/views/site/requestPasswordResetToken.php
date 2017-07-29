<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-boxs forgot-box col-md-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out your email. A link to reset password will be sent there.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email', ['template' => '<label for="email" class="fa fa-envelope" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['class'=>'form-control', 'placeholder'=>'Email','autofocus' => true, 'required'=>'required'])->label(false) ?>

                <div class="form-group" style="margin-bottom: 0;">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary form-control']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        