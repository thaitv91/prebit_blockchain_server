<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'PreBit account created - Email confirmation required';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Modal -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?=$this->title?></h4>
        </div>
        <div class="modal-body">
            <p>We have sent an email to: <?= $email ?>. Please click the link in that email to confirm your account.</p>
            <p>Check your SPAM FOLDER if you don't receive our email within a few minutes.</p>
        </div>
        <div class="modal-footer text-center" style="text-align:center">
            <?= Html::a('Login', ['site/login'], ['class'=>'btn btn-success']) ?>
        </div>
    </div>
</div>

<!-- <section>
    <div class="introduce">
            <div class="row">
                <div class="email_confirmation">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <h3 class="title"><?= $this->title ?></h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row active_content">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h4>An email has been sent to: <?= $email ?></h4>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p>Please check your email and validate your account.</p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

