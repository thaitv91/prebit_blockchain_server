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

    <h5>A link to reset your password has been sent to your email.</h5><p></p><p></p>
    <div class="text-center">
    <?php echo Html::a('Back to homepage', '/site/login', ['class'=>'btn btn-success']) ?>    
    </div>  
</div>
        