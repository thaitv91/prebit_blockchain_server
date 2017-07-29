<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/bootstrap/css/bootstrap.min.css',
        'libs/font-awesome/css/font-awesome.min.css',
        'libs/fontello/css/fontello.css',
        'libs/animate-css/animate.min.css',
        'libs/nifty-modal/css/component.css',
        'libs/magnific-popup/magnific-popup.css',
        'libs/pace/pace.css',
		'libs/jsdatepickerui/jquery-ui.css',
		'libs/bootstrap-daterangepicker/daterangepicker.css',
       // 'libs/bootstrap-datepicker/css/datepicker.css',
        'libs/jquery-easytree/easyTree.css',
        'libs/light-box/lightbox.min.css',

        
        //Extra CSS Libraries Start
        'libs/bootstrap-calendar/css/bic_calendar.css',
        'libs/bootstrap-xeditable/css/bootstrap-editable.css',        
        'css/style.css',
        'libs/jscrollpane/style/jquery.jscrollpane.css',

        //Extra CSS Libraries End
        'libs/summernote/summernote.css',
        'css/style-responsive.css',
        'css/boxchatwidget.css',
        'css/bootstrap-treeview.css',
        'css/bootstrap-timepicker.min.css',
        'css/daterangepicker.css',
        'css/jquery.mCustomScrollbar.css',
        'libs/jquery-datatables/css/dataTables.bootstrap.css',
        'css/customer.css',
        'css/stylesheets/custom-theme-2.css',
    ];
    public $js = [        
        'js/clipboard.min.js',
        'js/jquery-ui.min.js',
        'js/jquery.easyui.min.js',        
        'libs/bootstrap/js/bootstrap.min.js',               
        'libs/jqueryui/jquery-ui-1.10.4.custom.min.js',
        'libs/jquery-ui-touch/jquery.ui.touch-punch.min.js',
        'libs/jquery-detectmobile/detect.js',
        // 'libs/jquery-animate-numbers/jquery.animateNumbers.js',
        // 'libs/fastclick/fastclick.js',
        'libs/jquery-blockui/jquery.blockUI.js',
        'libs/bootstrap-bootbox/bootbox.min.js',
        'libs/jquery-slimscroll/jquery.slimscroll.js',
        'libs/jquery-sparkline/jquery-sparkline.js',
        'libs/nifty-modal/js/classie.js',
        'libs/nifty-modal/js/modalEffects.js',
        // 'libs/bootstrap-fileinput/bootstrap.file-input.js',
        'libs/bootstrap-select/bootstrap-select.min.js',
        'libs/bootstrap-select2/select2.min.js',
        'libs/magnific-popup/jquery.magnific-popup.min.js',
        'libs/pace/pace.min.js',
		'libs/jsdatepickerui/jquery-ui.js',
		'libs/bootstrap-daterangepicker/daterangepicker.js',
        //'libs/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'js/moment.min.js',
        'js/daterangepicker.js',
       // 'js/bootstrap-datepicker.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'libs/jquery-easytree/easyTree.js',
        'libs/jquery-mousewheel/jquery.mousewheel.min.js',
        'libs/jscrollpane/script/jquery.jscrollpane.min.js',
        'js/bootstrap-treeview.js',
        'js/notification.js',
        'js/boxchat.js',
        'js/jquery.timeago.js',
        'js/jquery.mCustomScrollbar.js',

        

        
        //Page Specific JS Libraries
        'js/init.js',
        'libs/summernote/summernote.js',
        'js/custom.js',
        'js/sha256.js',
        'js/BigInt.js',
        'js/validation_bitcoin_address.js',
        'js/select2.full.js',
        'js/Winwheel.js',
        'js/TweenMax.min.js',
        'js/luckydraw.js',
        'libs/jquery-datatables/js/jquery.dataTables.min.js',
        'libs/jquery-datatables/extensions/TableTools/js/dataTables.tableTools.min.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
