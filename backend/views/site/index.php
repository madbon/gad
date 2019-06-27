<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'GAD Plan and Budget Monitoring System - ADMIN PANEL';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">Admin <?= Yii::$app->user->identity->username ?></p>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-user"></span> &nbsp;Manage Users',['user/admin'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-star"></span> &nbsp;Role',['rbac/role'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> &nbsp;Permission',['rbac/permission'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-tag"></span> &nbsp;Category',['cms/category'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;Indicators',['cms/indicator'],['class' => 'btn btn-lg btn-primary']) ?>
                
        </p>
    </div>
</div>
