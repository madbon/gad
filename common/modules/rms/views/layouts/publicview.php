<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\web\View;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\bootstrap\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->user->can('bpls_answer_monitoring_form') ? 'BPLS-BPCO' : 'Rate My Service' ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .box.box-solid.box-primary {
            border: 1px solid #3c8dbc;
        }
        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative;
        }
        .box.box-primary {
            border-top-color: #3c8dbc;
        }

        .box {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 2px 3px rgba(0,0,0,0.2);
        }
        .box-body {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            padding: 10px;
        }
        .callout.callout-info {
            border-left-color: #3c8dbc;
        }
        .callout.callout-default {
            border-left-color: #848c91;
        }

        .callout {
            box-shadow: 0.2px 1px 1px 2px rgba(0,0,0,0.2);
            border-radius: 3px;
            margin: 0 0 20px 0;
            padding: 5px 30px 5px 15px;
            border-left: 5px solid #eee;
        }
        .bg-aqua, .callout.callout-info, .alert-info, .label-info, .modal-info .modal-body {         
            background-color: #fff !important;
            color: black;
        }
        .steps-step-2 .btn-circle-2 {
            width: 70px;
            height: 70px;
            border: 2px solid #59698D;
            background-color: white !important;
            color: #59698D !important;
            border-radius: 50%;
            padding: 22px 18px 15px 18px;
            margin-top: -22px;
        }
        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }
        .steps-form-2 {
            display: table;
            width: 80%;
            position: relative;
        }
        .justify-content-between {
            -ms-flex-pack: justify!important;
            justify-content: space-between!important;
        }
        .d-flex {
            display: -ms-flexbox!important;
            display: flex!important;
        }
        .steps-form-2 .steps-row-2:before {
            position: absolute;
            content: "";
            width: 100%;
            height: 3px;
            background-color: #7283a7;
            z-index: -1;
            margin-top: 14px;
        }
        #surveyLogo{
            margin-top: 50px;
            /*margin-left: 30px;*/
            width: 100%;
            position: fixed;
            z-index: -1;
        }
        .navbar-inverse .navbar-brand {
            color: #d6d6d6;
            background-color: #7d1b05;
            border-radius: 0 0 15px 15px;
        }
        .navbar-inverse .navbar-brand:hover {
            color: #ffffff;
            background-color: #7d1b05;
            border-radius: 0 0 15px 15px;
        }
        .navbar-inverse {
            background-color: #03274c;
            border-color: #03274c;
        }
        .navbar-inverse .navbar-nav > li > a {
            color: #d6d6d6;
            background-color: #7d1b05;
            border-radius: 0 0 15px 15px;
            margin-left: 1px;
        }
        .navbar-inverse .navbar-nav > li > a:hover {
            color: #ffffff;
            background-color: #7d1b05;
            border-radius: 0 0 15px 15px;
            margin-left: 1px;
        }
        .navbar-inverse .btn-link {
            color: #d6d6d6;
            background-color: #7d1b05;
            border-radius: 0 0 15px 15px;
            margin-left: 1px;
        }
        @media screen and (max-width: 767px) {
            .navbar-inverse .navbar-nav > li > a {
                color: #d6d6d6;
                background-color: #7d1b05;
                border-radius: 0;
                margin-left: 0;
                margin-bottom: 1px;
            }
            .navbar-inverse .navbar-nav > li > a:hover {
                color: #ffffff;
                background-color: #7d1b05;
                border-radius: 0;
                margin-left: 0;
                margin-bottom: 1px;
            }
            .navbar-inverse .btn-link {
                color: #d6d6d6;
                background-color: #7d1b05;
                border-radius: 0;
                margin-left: 0;
                margin-bottom: 1px;
            }
            .navbar-inverse .navbar-toggle:hover {
                background-color: #7d1b05;
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?php 
  $this->registerJs('
     $(".modalButton").click(function (){
        $.get($(this).attr("href"), function(data) {
          $("#modalDiv").modal().find("#modalContentDetails").html(data)
        });
       return false;
    });
  ', View::POS_END);
?>


<?php 
  Modal::begin([
    'header' => '<h4><div id="form_file"><strong>Attachment (Form)</strong></div></h4>',
    'id' => 'modalDiv',
    'size' => 'modal-lg',
  ]);
  echo "<div id='modalContentDetails'></div>";
  Modal::end();
?>

<div class="wrap">
    <?= Html::img('@web/uploads/banner.png', ['class' => 'img-responsive', 'id' => 'surveyLogo']) ?>
    <?php
    if(Yii::$app->user->can('bpls_admin_monitoring_form'))
    {
        $preLink = Yii::$app->homeUrl.'rms/dynamic-view/create';
    }
    else
    {
        if(!empty(Yii::$app->session['regionDefaultForm']))
        {
            // $preLink = Yii::$app->homeUrl.Yii::$app->session['regionDefaultForm'];
            $preLink = Yii::$app->homeUrl;
        }
        else
        {
            $preLink = Yii::$app->homeUrl;
        }
    }
    NavBar::begin([
        'brandLabel' => Yii::$app->user->can('bpls_answer_monitoring_form') ? 'BPLS-BPCO Monitoring Form' : 'Rate My Service',
        'brandUrl' => $preLink,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<i class="glyphicon glyphicon-home"></i> Home', 'url' => [!empty(Yii::$app->session['regionDefaultForm']) ? '/'.Yii::$app->session['regionDefaultForm'] : 'dynamic-view/index']],
        Yii::$app->user->can('bpls_admin_monitoring_form') ? ['label' => '<i class="glyphicon glyphicon-cog"></i> Admin Panel', 'url' => [!empty(Yii::$app->session['regionDefaultForm']) ? '/'.Yii::$app->session['regionDefaultForm'] : '/']] : "",
    ];
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => '<i class="glyphicon glyphicon-log-in"></i> Login', 'url' => ['/user/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '<i class="glyphicon glyphicon-log-out"></i> Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => false
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->user->can('bpls_answer_monitoring_form') ? 'BPLS-BPCO Monitoring Form' : 'Rate My Service' ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<script type="text/javascript">
    $('form').attr('autocomplete','off');
</script>
</html>
<?php $this->endPage() ?>
