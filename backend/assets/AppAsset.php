<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //fontawesome
        'css/font-awesome/4.6.3/css/font-awesome.min.css',

        //page specific plugin styles

        //text fonts
        'fonts/fonts.googleapis.com.css',
        'css/jquery-ui.custom.min.css',
        'css/jquery.gritter.min.css',
        'css/chosen.min.css',


        //ace styles
        'css/select2.min.css',
        'css/bootstrap-editable.min.css',
        'css/ace.min.css',
        'css/bootstrap-timepicker.min.css',
        'css/daterangepicker.css',
        'css/bootstrap-duallistbox.min.css',
        'css/colorpicker.min.css',

        /*[if lte IE 9]
            <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->
        */
    ];
    public $js = [
        'js/ace-extra.min.js',
        'js/jquery-ui.custom.min.js',
        'js/jquery.ui.touch-punch.min.js',
        'js/chosen.jquery.min.js',
        'js/jquery.easypiechart.min.js',
        'js/jquery.sparkline.min.js',
        'js/jquery.flot.min.js',
        'js/jquery.flot.pie.min.js',
        'js/jquery.flot.resize.min.js',
        'js/bootstrap.min.js',


        //ace settings handler
        'js/ace-extra.min.js',

        //ace scripts
        'js/ace-elements.min.js',
        'js/ace.min.js',

        'js/jquery-ui.custom.min.js',
        'js/jquery.ui.touch-punch.min.js',
        'js/jquery.gritter.min.js',
        'js/bootstrap-wysiwyg.min.js',
        'js/bootstrap-colorpicker.min.js',
        'js/bootstrap-tag.min.js',
        'js/jquery.hotkeys.min.js',
        'js/bootstrap-editable.min.js',
        'js/select2.min.js',
        'js/moment.min.js',
        'js/daterangepicker.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/bootstrap-datepicker.min.js',
        'js/fuelux.spinner.min.js',
        'js/bootbox.min.js',
        'js/ace-editable.min.js',
        'js/jquery.maskedinput.min.js',
        'js/jquery.bootstrap-duallistbox.min.js',
        'js/jquery.nestable.min.js',
        'js/jquery.dataTables.min.js',
        
        
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
