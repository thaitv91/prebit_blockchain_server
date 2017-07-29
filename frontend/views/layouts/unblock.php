<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\widgets\SidebarWidget;
use frontend\components\widgets\TopbarWidget;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">
    <div class="topbar"><!-- Top Bar Start -->
        <?= TopbarWidget::widget() ?>      
    </div><!-- Top Bar End -->        
    <div class="page-unlock content-page">
            <div class="content">                
                <div class="row token-history token-manager">
                    <div class="col-md-8 col-md-offset-2">
                        <?=$content?>
                    </div>
                </div><!--token-history-->      
            </div><!-- End content here -->
        </div><!--content-page-->

    <footer class="text-center">
        &copy; 2017 PreBit. All rights reserved.
    </footer>
    <!-- Footer End -->         
</div>
</div>
<div class="md-overlay"></div>
<script>
    var resizefunc = [];
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
