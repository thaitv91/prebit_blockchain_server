<?php 

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'PreBit - Help others. Live better.';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>PreBit - Your Choosen is No.1</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/libs/font-awesome/css/font-awesome.min.css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" type="text/css" href="/css/customer.css">
        <link rel="stylesheet" type="text/css" href="/css/login.css">
		<SCRIPT type="text/javascript">
	window.history.forward();
	function noBack() { window.history.forward(); }
</SCRIPT>
    </head>

    <body class="login-layout" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
        <div class="container">
            <div class="form-box2">                
                <?= $content ?>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
//     $(document).ready(function(){
//         $('iframe').load( function() {
//             $('iframe').contents().find("head")
//               .append($("<style type='text/css'>  .rc-inline-block{display:none;}  </style>"));
//         });
//     })
</script>
