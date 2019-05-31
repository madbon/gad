<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
i.location_name
{
    background-color: yellow;
    color: black;
    padding: 5px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: bold;
    /*color: ;*/
}
i.permission_denied
{
    font-size: 15px;
    color:orange;
}
i.role_name
{
    /*font-weight: bold;*/
    color: yellow;
    font-style: normal;
    font-size: 15px;
    text-transform: uppercase;
    font-size: 13px;
    /*padding:8px;*/
    /*background-color: #4D2A4F;*/
    /*border-radius: 15px;*/
}
ul.nav li a:hover
{
    color:gray;
}
ul.nav li.disabled a
{
    color:white;
}
ul.nav li.disabled a:hover
{
    color:white;
}
ul.nav li.disabled:hover
{
    background-color: #7cbc7c;
    color:white;
}

nav.navbar
{
    background-color: #29102E !important;
    width: 100%;
}

nav#w0
{
    width: 100%;
}
nav.navbar div.container
{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
    padding-top: 5px;
    padding-bottom: 5px;
}
div.navbar-header a img
{
    height: 40px;
    margin-top: -10px;
    margin-right: 10px;
    display: inline;
}
.navbar-inverse .navbar-brand
{
    color:white;
    font-size: 15px;
}
.navbar-inverse .navbar-brand:hover
{
    color:#DDA8B5 ;
}
/* if nav menu is active*/
.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus
{
    background-color:#4D2A4F;
    border-radius: 10px;
}

.navbar-inverse .navbar-nav > li > a
{
    color: whitesmoke;
    /*font-size: 15px;*/
}
.navbar-inverse .navbar-nav > li > a:hover
{
    color:#DDA8B5;
}
/*Panel*/
.cust-panel
{
    width: 100%;
    box-shadow: 0.5px 0.5px 0.5px 0.5px rgba(155,155,155,0.5);
}
.success
{
    background-color: #174369 !important;
    height: 2px;
}
.gad-color
{
    background-color: #29012cc4 !important;
    height: 3px;
}
.cust-panel .cust-panel-header
{

}
.cust-panel .cust-panel-body
{
    background-color: white !important;
    min-height: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 15px;
}
.cust-panel .cust-panel-title p
{
    font-size:25px;
}
.cust-panel .cust-panel-title
{
    border-bottom: 1px solid rgba(150,150,150,0.5);
    padding-top: 10px;
    margin-bottom: 10px;
}
/*#f1e5e8;*/
/*Panel*/
</style>
<body>
<?php $this->beginBody() ?>
<div class="wrap" style="background-color: #8080802e;">
   <?php
        $logo =  Html::img('@web/images/dilg-logo.png',['class']);

        if (Yii::$app->user->isGuest) {
            NavBar::begin([
                'brandLabel' => $logo.'GAD-PBMS | Gender and Development Plan and Budget Monitoring System',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems[] = ['label' => 'Signup', 'url' => ['/user/register']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
        } else {
            $officer_role = "";
            $location_name = "";
            if(Yii::$app->user->can("gad_lgu"))
            {
                $officer_role = "lgu";
                $location_name = !empty(Yii::$app->user->identity->userinfo->citymun->citymun_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->citymun->citymun_m."</i>" : "";
            }
            elseif(Yii::$app->user->can("gad_field"))
            {
                $officer_role = "field officer";
                $location_name = !empty(Yii::$app->user->identity->userinfo->citymun->citymun_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->citymun->citymun_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_province"))
            {
                $officer_role = "provincial officer";
                $location_name = !empty(Yii::$app->user->identity->userinfo->province->province_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->province->province_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_region"))
            {
                $officer_role = "regional officer";
                $location_name = !empty(Yii::$app->user->identity->userinfo->region->region_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->region->region_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_central"))
            {
                $officer_role = "central";
            }
            else if(Yii::$app->user->can("gad_admin"))
            {
                $officer_role = "administrator";
            }
            else
            {
                $officer_role = null;
            }

            if(!empty($officer_role))
            {
                NavBar::begin([
                    'brandLabel' => $logo.'GAD-PBMS | Gender and Development Plan and Budget Monitoring System | <i class="role_name">'.$officer_role.$location_name.'</i>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                    ],
                ]);
                $menuItems = [
                    [
                        'label' => 'Home','url' => ['/site/index']],

                    Yii::$app->user->can('gad_menu_create') ? [
                        'label' => 'Create', 'items' => [
                            Yii::$app->user->can('gad_create_planbudget') ? ['label' => 'Plan and Budget', 'url' =>  ['/report/gad-record/create','ruc'=>'empty','onstep'=>'create_new','tocreate'=>'gad_plan_budget']] : "",
                            Yii::$app->user->can('gad_create_accomplishment') ? ['label' => 'Accomplishment Report', 'url' =>  ['/report/gad-record/create','ruc'=>'empty','onstep'=>'create_new','tocreate'=>'accomp_report']] : "",
                        ],
                    ] : "",
                    Yii::$app->user->can('gad_menu_report') ? [
                        'label' => 'Report', 'items' => [
                            Yii::$app->user->can('gad_viewreport_planbudget') ? ['label' => 'GAD Plan and Budget', 'url' => ['/report/gad-record/','report_type' => 'plan_budget']] : "",
                            Yii::$app->user->can('gad_viewreport_accomplishment') ? ['label' => 'Accomplishment Report', 'url' => ['/report/gad-record/','report_type' => 'accomplishment' ]] : "",
                        ],
                        // 'url' => ['/site/about']
                    ] : "",
                    // ['label' => 'Contact', 'url' => ['/site/contact']],
                ];
            }
            else // if empty officer role
            {
                NavBar::begin([
                    'brandLabel' => $logo.'GAD-PBMS | Gender and Development Plan and Budget Monitoring System | <i class="permission_denied">Permission Denied</i>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                    ],
                ]);
            } // end- if empty officer role
            $menuItems[] = '<li>'
                . Html::beginForm(['/user/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
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

    <div class="container" style="width: 96%; margin-left: 2%; margin-right: 2%; ">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <p class="main-title"> 

            <?= Html::encode($this->title) ?>
                
        </p>
        <?= $content; ?>

        
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
