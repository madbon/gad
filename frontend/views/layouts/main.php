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
.cust-panel .cust-panel-header
{
    background-color: #8b588e !important;
    height: 5px;

}
.cust-panel .cust-panel-body
{
    background-color: white;
    min-height: 200px;
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
/*Panel*/
</style>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="background-color: #f1e5e8;">
   <?php
        $logo =  Html::img('@web/images/dilg-logo.png',['class']);
        NavBar::begin([
            'brandLabel' => $logo.'GAD-PBMS | Gender and Development Plan and Budget Monitoring System',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            [
                'label' => 'Home','url' => ['/site/index']],
            ['label' => 'Report', 'items' => [
                    ['label' => 'GAD Plan and Budget (Annex A)', 'url' => '@web/report/gad-plan-budget/'],
                    ['label' => 'List of Annex A', 'url' => '@web/report/gad-record/'],
                ],
                'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/user/register']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
        } else {
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
        <div class="cust-panel">
            <div class="cust-panel-header">
            </div>
            <div class="cust-panel-body">
                <div class="cust-panel-title">
                    <p>
                        <?= Html::encode($this->title) ?>
                    </p>
                </div>
                <?= $content; ?>
            </div>
        </div>
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
