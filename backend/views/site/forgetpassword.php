<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Forget Password';
?>
<div id="forgot-box" class="forgot-box visible  widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="ace-icon fa fa-key"></i>
                Retrieve Password
            </h4>

            <div class="space-6"></div>
            <p>
                Enter your email and to receive instructions
            </p>
            <?php $form = ActiveForm::begin(['id' => 'forgetpassword-form']); ?>
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Nhập địa chỉ email', 'class' => 'form-control' ])->label(false) ?>
                            <p class="txt_forgot_email help-block help-block-error red"></p>
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>

                    <div class="clearfix">
                        <?= Html::submitButton('<i class="ace-icon fa fa-lightbulb-o"></i><span class="bigger-110">Send Me!</span>', ['class' => 'width-35 pull-right btn btn-sm btn-danger']) ?>
                    </div>
                </fieldset>
            <?php ActiveForm::end(); ?>
        </div><!-- /.widget-main -->

        <div class="toolbar center">
            <?=Html::a('Back to login<i class="ace-icon fa fa-arrow-right"></i>', Yii::$app->urlManager->createAbsoluteUrl('/site/login'), ['class'=>'back-to-login-link']);?>
        </div>
    </div><!-- /.widget-body -->
</div><!-- /.forgot-box -->