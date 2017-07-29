<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'PreBit - Your Choosen is No.1';
$this->params['breadcrumbs'][] = $this->title;

require_once 'GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$secret = $ga->createSecret();

?>

<div class="login-boxs col-md-3">
<h1 class="text-center">
    <img src="<?= Yii::$app->params['url_file'] ?>/images/logo.png" alt="bitway">
</h1>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username', ['template' => '<label for="email" class="fa fa-user" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['autofocus' => true, 'class'=>'form-control', 'placeholder'=>'Username', 'required'=>'required'])->label(false) ?>

    <input type="hidden" name="google_secret_code" value="<?=$secret?>">

    <?= $form->field($model, 'password', ['template' => '<label for="email" class="fa fa-key" rel="tooltip" title="email"></label>{input}{hint}{error}'])->passwordInput(['class'=>'form-control', 'placeholder'=>'Password', 'required'=>'required'])->label(false) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="pull-right lost-pass" style="color:#999;margin:0.5em 0">
        <?= Html::a('Forgot password ?', ['site/request-password-reset']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary form-control', 'name' => 'login-button']) ?>
    </div>
	<div style="clear: both"></div>
	<div class="meta-footer">

		<div class="pull-right">
			<a href="<?= Yii::$app->params['home_url'] ?>" title="PreBit">Back to website</a>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
