<?php
require_once 'GoogleAuthenticator.php';

$ga = new GoogleAuthenticator();

//$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'system.bitway.org');
//echo $qrCodeUrl;exit;

if(!empty($code)){
	$checkResult = $ga->verifyCode($secret, $code, 2);
}

if($checkResult){
	$_SESSION['googleCode']=$code;
	$session['google_auth'] = '0';
	$session['is_auth_tw'] = '0';
	echo "1";exit;
}else{
	$session['google_auth'] = '1';
	echo "0";exit;
}
?>