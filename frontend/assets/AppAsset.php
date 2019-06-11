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
        // 'sbadmin2/vendor/fontawesome-free/css/all.min.css',
        // 'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        // 'sbadmin2/css/sb-admin-2.min.css',

    ];
    public $js = [
        // 'sbadmin2/vendor/jquery/jquery.min.js',
        // 'sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js',
        // 'sbadmin2/vendor/jquery-easing/jquery.easing.min.js',
        // 'sbadmin2/js/sb-admin-2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
