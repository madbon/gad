<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'GAD Plan and Budget Monitoring System - ADMIN PANEL';
?>
<div class="site-index">

    <h3>User Management</h3>
    <?php if(Yii::$app->user->can("gad_user_management")){ ?>
        <?= Html::a('<span class="glyphicon glyphicon-user"></span> &nbsp;Manage Users',['user/admin'],['class' => 'btn btn-lg btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-star"></span> &nbsp;Role',['rbac/role'],['class' => 'btn btn-lg btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> &nbsp;Permission',['rbac/permission'],['class' => 'btn btn-lg btn-primary']) ?>
    <?php } ?>

    <h3>Dynamic Form CMS</h3>
    <?= Html::a('<span class="glyphicon glyphicon-tag"></span> &nbsp;Category',['cms/category'],['class' => 'btn btn-lg btn-primary']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;Indicators',['cms/indicator'],['class' => 'btn btn-lg btn-primary']) ?>

    <?php if(Yii::$app->user->can("gad_lookup_tables")){ ?>
        <h3>Look-up tables</h3>
        
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Report Status',['admin/status'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Activity Category',['admin/activity-category'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> PPA Sectors',['admin/gad-ppa-attributed-program'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Checklists',['admin/checklist'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> File Types',['admin/file-folder-type'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Focus Types',['admin/gad-focused'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Inner Category After Focus',['admin/gad-inner-category'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> HGDG Score Type',['admin/score-type'],['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Status Assignment',['admin/status-assignment'],['class' => 'btn btn-lg btn-primary']) ?>
    <?php } ?>
</div>
