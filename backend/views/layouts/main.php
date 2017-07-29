<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\components\widgets\SidebarWidget;
use backend\components\widgets\TopnavWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="us">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="no-skin">
<?php $this->beginBody() ?>

<div class="wrap">
    <div id="navbar" class="navbar navbar-default">
        <?= TopnavWidget::widget() ?>
    </div>

    <div id="main-container" class="main-container">
        <div id="sidebar" class="sidebar responsive">
            <?= $this->registerJs("try{ace.settings.check('sidebar' , 'fixed')}catch(e){}");?>
            <?= SidebarWidget::widget() ?>
            <?= $this->registerJs("try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}");?>
        </div>
        <div class="main-content">
            <div class="main-content-inner">
                <div id="breadcrumbs" class="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <a href="#">Home</a>
                        </li>

                        <li>
                            <a href="#">Tables</a>
                        </li>
                        <li class="active">Simple &amp; Dynamic</li>
                    </ul><!-- /.breadcrumb -->

                    <div id="nav-search" class="nav-search">
                        <form class="form-search">
                            <span class="input-icon">
                                <input type="text" autocomplete="off" id="nav-search-input" class="nav-search-input" placeholder="Search ...">
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div><!-- /.nav-search -->
                </div>
                <?= $content ?>
            </div>
        </div><!-- /.main-content -->
    </div>
    <div class="clear-fix"></div>
</div>

<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder">Bitway</span>
                Application &copy; 2016
            </span>

            &nbsp; &nbsp;
            <span class="action-buttons">
                <a href="#">
                    <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                </a>

                <a href="#">
                    <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                </a>

                <a href="#">
                    <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                </a>
            </span>
        </div>
    </div>
</div>
<a class="btn-scroll-up btn btn-sm btn-inverse display" id="btn-scroll-up" href="#">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>

<?php $this->endBody() ?>

<?= $this->registerJs("try{ace.settings.check('navbar' , 'fixed')}catch(e){}");?>
<?= $this->registerJs("
    jQuery(function($) {
        $('#tasks').sortable({
            opacity:0.8,
            revert:true,
            forceHelperSize:true,
            placeholder: 'draggable-placeholder',
            forcePlaceholderSize:true,
            tolerance:'pointer',
            stop: function( event, ui ) {
                //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                $(ui.item).css('z-index', 'auto');
            }
            }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
            if(this.checked) $(this).closest('li').addClass('selected');
            else $(this).closest('li').removeClass('selected');
        });
    
    
        //show the dropdowns on top or bottom depending on window height and menu position
        $('#task-tab .dropdown-hover').on('mouseenter', function(e) {
            var offset = $(this).offset();
    
            var w = $(window)
            if (offset.top > w.scrollTop() + w.innerHeight() - 100) 
                $(this).addClass('dropup');
            else $(this).removeClass('dropup');
        });
    
    });
")?>



</body>
</html>
<?php $this->endPage() ?>


