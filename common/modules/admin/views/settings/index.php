<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<style type="text/css">
div.row div.col-sm-3 a.btn
{
    text-align: left;
    padding-left: 20px;
    margin:5px 5px 5px 0px;
}
</style>

<?php if(Yii::$app->user->can("SuperAdministrator") || Yii::$app->user->can("Administrator") || Yii::$app->user->can("RegionalAdministrator") || Yii::$app->user->can("gad_admin")){ ?>
    <h3>User Management</h3>
    <div class="row">
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-user"></span> &nbsp;Manage Users',['/user/admin'],['class' => 'btn btn-lg btn-primary btn-block']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-star"></span> &nbsp;Role',['/rbac/role'],['class' => 'btn btn-lg btn-primary btn-block']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> &nbsp;Permission',['/rbac/permission'],['class' => 'btn btn-lg btn-primary btn-block']) ?>
        </div>
    </div>
    <h3>Dynamic Form CMS</h3>
    <div class="row">
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-tag"></span> &nbsp;Category',['/cms/category'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;Indicators',['/cms/indicator'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
    </div>
    <h3>Look-up tables</h3>
    <div class="row">
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Report Status',['/admin/status'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Report Status Assignment',['/admin/status-assignment'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Activity Category',['/admin/activity-category'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> PPA Sectors',['/admin/gad-ppa-attributed-program'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Checklists',['/admin/checklist'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> File Types',['/admin/file-folder-type'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Focus Types',['/admin/gad-focused'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Inner Category After Focus',['/admin/gad-inner-category'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> HGDG Score Type',['/admin/score-type'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> Year',['/admin/year'],['class' => 'btn btn-lg btn-primary']) ?>
        </div>
    </div>
<?php } ?>

<?php
    $this->registerJs("
        $('.row .col-sm-3 a.btn').addClass('btn-block');
    ");
?>