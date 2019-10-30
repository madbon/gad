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
        'css/site.css',
        'css/customStyle.css',
        'sbadmin2/css/bootstrap.min.css',
        'sbadmin2/font-awesome/css/font-awesome.css',
        'sbadmin2/css/sb-admin.css',

    ];
    public $js = [
        // 'sbadmin2/js/jquery-1.10.2.js',
        'sbadmin2/js/bootstrap.min.js',
        'sbadmin2/js/plugins/metisMenu/jquery.metisMenu.js',
        'sbadmin2/js/sb-admin.js',
        'js/main.js',
        'js/dragscroll.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
