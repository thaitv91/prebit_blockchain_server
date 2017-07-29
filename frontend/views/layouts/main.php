<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url ;
use frontend\components\widgets\SidebarWidget;
use frontend\components\widgets\TopbarWidget;
use common\models\Newsmanagement;

$notification = Newsmanagement::find()->where(['id' => 13])->orderBy(['created_at' => SORT_DESC])->one();
AppAsset::register($this);

$session = Yii::$app->session;
file_put_contents('newsession.txt',$session['is_auth_tw']);
if($session['is_auth_tw']=='1'){
return Yii::$app->response->redirect(Url::to(['site/login']));
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../js/jquery.pause.min.js"></script>
    <script src="../js/jquery.easing.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?= Yii::$app->params['url_file'] ?>/images/favicon.ico">
    <?php $this->head() ?>
</head>
<body class="fixed-left">
<?php $this->beginBody() ?>

<div id="wrapper">
    <div class="topbar top-menu"><!-- Top Bar Start -->
        <?= TopbarWidget::widget() ?>      
    </div><!-- Top Bar End -->        
    <!-- Left Sidebar Start -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">   

        <?= SidebarWidget::widget() ?>             
            <div class="clearfix"></div>
        </div>            
    </div>
    <!-- Left Sidebar End -->
    <div class="content-page">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="content">
            
            <div class="send-hep-row top hidden-xs">
                <div class="right-send-help marquee">
                    <?php echo $notification["content"]; ?>                         
                </div>
            </div><!--send-hep-row-->

            <?= $content ?>
            <footer class="text-center">
                &copy; 2017 PreBit. All rights reserved.
            </footer><!-- Footer End -->  

             
        </div>    
    </div>
</div>
<div class="md-overlay"></div>
<script>
    var resizefunc = [];
</script>
<?php $this->endBody() ?>
<script src="/js/jquery.marquee.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.marquee').marquee({
            speed: 15000,
            gap: 50,
            delayBeforeStart: 0,
            direction: 'left',
            duplicated: true,
            pauseOnHover: true
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
