<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register - PreBit';
?>

<div class="register-boxs col-md-4">
<h1 class="text-center">
    <img src="<?= Yii::$app->params['url_file'] ?>/images/logo.png" alt="bitway">
</h1>
<?php 
if(!empty($_GET['u'])){
	$username = $_GET['u'];
}else{
	$username = '';
}
?>
	<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<p style="font-size: 13px;">Referral Username is optional</p>
		<?= $form->field($model, 'referral_id',['template' => '<label for="referral_id" class="fa fa-sitemap" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['maxlength' => true, 'class'=>'form-control', 'placeholder'=>'Referral Username', 'value'=>$username])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<p style="font-size: 13px;">Please enter your real name</p>
		<?= $form->field($model, 'fullname', ['template' => '<label for="fullname" class="fa fa-user-secret" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['class'=>'form-control', 'placeholder'=>'Full name', 'required'=>'required'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?= $form->field($model, 'username', ['template' => '<label for="username" class="fa fa-user" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['class'=>'form-control', 'placeholder'=>'Username', 'required'=>'required'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?= $form->field($model, 'email', ['template' => '<label for="email" class="fa fa-envelope" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['class'=>'form-control', 'placeholder'=>'Email', 'required'=>'required'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?= $form->field($model, 'password', ['template' => '<label for="password" class="fa fa-key" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['type'=>'password', 'class'=>'form-control', 'placeholder'=>'Password', 'required'=>'required'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	<?= $form->field($model, 'password_repeat', ['template' => '<label for="password_repeat" class="fa fa-key" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['type'=>'password', 'class'=>'form-control', 'placeholder'=>'Confirm Password'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?= $form->field($model, 'phone',['template' => '<label for="phone" class="fa fa-mobile" rel="tooltip" title="email"></label>{input}{hint}{error}'])->textInput(['type' => 'number', 'class'=>'form-control', 'placeholder'=>'Mobile Phone', 'required'=>'required'])->label(false) ?>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?= $form->field($model, 'country')->dropDownList($model->listCountry, ['prompt'=>'Select Country', 'class'=>'form-control', 'placeholder'=>'Select country', 'required'=>'required'])->label(false); ?>
	</div>
	

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?= $form->field($model, 'accept')->checkbox()->label('I accept Terms and Conditions');?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?= Html::submitButton('Create Account', ['class' => 'btn btn-sm btn-primary text-center form-control', 'name' => 'register-button']) ?>
	</div>
	<div class="text-center bottom-alre" style="float: left;width: 100%; padding-top: 10px;">
		<p style="margin-bottom: 0">
			Already a member?
			<?=Html::a('Login now!', Yii::$app->urlManager->createAbsoluteUrl('/site/login'), ['data-method'=>'post']);?>
		</p>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript" src="<?= Yii::$app->params['url_file'] ?>/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript">
	$('#registerform-username').keyup(function(){
		var string = $(this).val();
		var replace_str = string.replace(/[^\x00-\x7F]/g, '');
		$(this).val(replace_str);
	})
	// $('#registerform-phone').keyup(function () {
	//     var reg = /^0+/gi;
	//     if (this.value.match(reg)) {
	//         this.value = this.value.replace(reg, '');
	//     }
	// });
</script>