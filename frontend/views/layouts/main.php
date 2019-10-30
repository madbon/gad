<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Url;

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
.cust-panel .cust-panel-body
{
    background-color: white;
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
    border-bottom: 2px solid white;
    padding-top: 10px;
    margin-bottom: 10px;
}
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
    /* background-color: #29012cc4 !important; */
    background-color: #7e57b1 !important;
    height: 3px;
}

ul li.activelink
{
    background-color: #7e57b1 !important;
}
ul li.activelink:hover
{
    background-color: #7e57b1 !important;
}
ul li.activelink a:hover
{
    color:white;
    background-color: #926bc4 !important;
}
ul li.activelink a
{
    color: white;
}
ul.nav-tabs li.disabled a
{
    color:whitesmoke;
}

.navbar-static-side
{
    margin-top: 51px;
}

/*ul.nav li.activeLink
{
    background-color: #7e57b1;
}
ul.nav li.activeLink a
{
    color: white;
}
ul.nav li.activeLink a:hover
{
    color:white;
    background-color: red;
}*/

i.location_name
{
    font-style: normal;
}
/*nav.navbar-default
{
    background-color: #935bdc !important;
}
nav.navbar-default div.navbar-header a
{
    color:white !important;
}*/
img.file-preview-image
{
    height: auto !important;
    width: auto !important;
    max-height: 100% !important;
    max-width: 100% !important;

}
nav.navbar-default div.navbar-header a
{
    color: #7e57b1;
}
/*.clearfix
{
    min-height: 1000px;
    overflow-y: scroll !important;
}*/
/*#f1e5e8;*/
/*Panel*/
</style>
<body>
<?php $this->beginBody() ?>
<?php
    $this->registerJs("
        $('img.file-preview-image').addClass('img-responsive');
    ");
?>
<?php
    Modal::begin([
        // 'header'=>'<h4>Person</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
            'options' => [
            'tabindex' => false, // important for Select2 to work properly
            'data-keyboard' => false,
            'data-backdrop' => 'static',
            ],
        ]);
        echo '<div id="modalContent"></div>';
    Modal::end();
?>
        <?php if (Yii::$app->user->isGuest) { ?>

            <?php
                $this->registerJs("
                    $('#page-wrapper').css({'margin':'0'});
                ");
            ?>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                    $logo =  Html::img('@web/images/dilg-logo.png',['class', 'style' => 'height:35px; width:35px; margin-top:-8px;']);
                ?>
                <a class="navbar-brand customactive" href="#"><i><?= $logo ?></i> GAD Plan and Budget Monitoring System </a>
                <ul class="nav navbar-top-links navbar-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <?php echo Html::a("Login",['/user/login/'], ['class' => 'btn btn-link']); ?>
                        <!-- /.dropdown-user -->
                    </li>
                    <li>
                        <?php echo Html::a("Sign Up",['/user/register/'], ['class' => 'btn btn-link']); ?>
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
        </nav>
        <?php }else{ 

        // $this->registerJs("
        //     $('.navbar-brand').click(function(){
        //         if($('.navbar-brand').hasClass('customactive')){
        //             $('#side-menu').hide();
        //             $('#page-wrapper').css({'margin':'0'});
        //         }
        //         else
        //         {
        //             $('#side-menu').show();
        //         }
        //     });
            
        // ");
            
        echo '<div id="wrapper">';
            $officer_role = "";
            $location_name = "";
            if(Yii::$app->user->can("gad_lgu_permission"))
            {
                $officer_role = "LGU C/M OFFICE";
                $location_name = !empty(Yii::$app->user->identity->userinfo->citymun->citymun_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->citymun->citymun_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_field_permission"))
            {
                $officer_role = "C/MLGOO";
                $location_name = !empty(Yii::$app->user->identity->userinfo->citymun->citymun_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->citymun->citymun_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_province_permission"))
            {
                $officer_role = "PROVINCIAL OFFICE";
                $location_name = !empty(Yii::$app->user->identity->userinfo->province->province_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->province->province_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_region_permission"))
            {
                $officer_role = "REGIONAL OFFICE";
                $location_name = !empty(Yii::$app->user->identity->userinfo->region->region_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->region->region_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_central_permission"))
            {
                $officer_role = "CENTRAL";
            }
            else if(Yii::$app->user->can("gad_admin_permission"))
            {
                $officer_role = "ADMINISTRATOR";
            }
            else if(Yii::$app->user->can("gad_lgu_province_permission"))
            {
                $officer_role = "LGU PROVINCIAL OFFICE";
                $location_name = !empty(Yii::$app->user->identity->userinfo->province->province_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->province->province_m."</i>" : "";
            }
            else if(Yii::$app->user->can("gad_ppdo_permission"))
            {
                $officer_role = "LGU-PPDO";
                $location_name = !empty(Yii::$app->user->identity->userinfo->province->province_m) ? " <i class='location_name'>".Yii::$app->user->identity->userinfo->province->province_m."</i>" : "";
            }
            else
            {
                $officer_role = null;
            }
        ?>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>  
                    <span class="icon-bar"></span>
                </button>
                <?php
                    $logo =  Html::img('@web/images/dilg-logo.png',['class', 'style' => 'height:35px; width:35px; margin-top:-8px;']);
                ?>
                <a class="navbar-brand" href="#"><i><?= $logo ?></i> GAD Plan and Budget Monitoring System </a>
            </div>
            <!-- /.navbar-header -->
            
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?= "<i>".Yii::$app->user->identity->username."</i> | ".$officer_role." | ".$location_name ?>  
                        
                       
                    </a>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php if(Yii::$app->user->can('gad_dashboard_menu')){ ?>
                            <?= Yii::$app->session["activelink"] == "dashboard" ? "<li class='activelink'>" : "<li>" ?>
                                <?= Html::a('<i class="fa fa-dashboard fa-fw"></i> Dashboard',['/report/dashboard']); ?>
                            </li>
                        <?php } ?>
                        
                        <?php if(Yii::$app->user->can('gad_menu_report')){ ?>    
                            <?php if(Yii::$app->controller->id == "gad-plan-budget" || Yii::$app->controller->id == "gad-record" && Yii::$app->session["activelink"] == "plan_budget" || Yii::$app->session["activelink"] == "accomplishment"){  ?>
                            <li class="active">
                                <a href="#"><i class="fa fa-search"></i> Search Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse in">
                            <?php }else{ ?>
                            <li>
                                <a href="#"><i class="fa fa-search"></i> Search Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                            <?php } ?>
                                <?php if(Yii::$app->user->can('gad_viewreport_planbudget')){ ?>
                                    <?php if(Yii::$app->session["activelink"] == "plan_budget" || Yii::$app->session["activelink"] == "gad_plan_budget"){ ?>
                                        <li class="activelink">
                                    <?php }else{ ?>
                                        <li>
                                    <?php } ?>
                                            <?php echo Html::a("Plan & Budget",['/report/gad-record/','report_type' => 'plan_budget']); ?>
                                        </li>
                                <?php } ?>
                                <?php if(Yii::$app->user->can('gad_viewreport_accomplishment')){ ?>
                                    <?php if(Yii::$app->session["activelink"] == "accomplishment" || Yii::$app->session["activelink"] == "accomp_report"){ ?>
                                        <li class="activelink">
                                    <?php }else{ ?>
                                        <li>
                                    <?php } ?>
                                            <?php echo Html::a("Accomplishment",['/report/gad-record/','report_type' => 'accomplishment']); ?>
                                        </li>
                                <?php } ?>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>
                        <?php if(Yii::$app->user->can('gad_menu_create')){ ?>
                            <?php if(Yii::$app->controller->id == "gad-record" && Yii::$app->session["activelink"] == "gad_plan_budget" || Yii::$app->session["activelink"] == "accomp_report"){ ?>
                            <li class="active">
                                <a href="#"><i class="fa fa-pencil"></i> Create<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                            <?php }else{ ?>
                            <li>
                                <a href="#"><i class="fa fa-pencil"></i> Create<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                            <?php } ?>
                                <?php if(Yii::$app->user->can('gad_create_planbudget')){ ?>
                                    <?php if(Yii::$app->session["activelink"] == "gad_plan_budget"){ ?>
                                        <li class="activelink">
                                    <?php }else{ echo "<li>"; } ?>
                                            <?php echo Html::a("Plan & Budget",['/report/gad-record/create','ruc'=>'empty','onstep'=>'create_new','tocreate'=>'gad_plan_budget']); ?>
                                        </li>
                                <?php } ?>

                                <?php if(Yii::$app->user->can('gad_create_accomplishment')){ ?>
                                    <?php if(Yii::$app->session["activelink"] == "accomp_report"){ ?>
                                        <li class="activelink">
                                    <?php }else{ echo "<li>"; } ?>
                                            <?php echo Html::a("Accomplishment",['/report/gad-record/create','ruc'=>'empty','onstep'=>'create_new','tocreate'=>'accomp_report']); ?>
                                        </li>
                                <?php } ?>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>
                        
                        <?php 
                            if(Yii::$app->user->can("gad_document_menu"))
                            {
                                if(Yii::$app->session["activelink"] == "created_document")
                                {
                                    echo "<li class='activelink'>".Html::a('<span class="fa fa-file"></span> Documents', ['/cms/document/created-document'])."</li>";
                                }
                                else
                                {
                                    echo "<li>".Html::a('<span class="fa fa-file"></span> Documents', ['/cms/document/created-document'])."</li>";
                                }
                            }
                        ?>

                        <?php if(Yii::$app->user->can("gad_cms_super_admin")){ ?>
                            <li>
                                <a href="#"><i class="fa fa-cogs"></i> Settings<span class="fa arrow"></span></a>
                                <?php
                                    if(Yii::$app->controller->id == "settings" || Yii::$app->controller->id == "archive" || Yii::$app->controller->module->id == "admin" )
                                    {
                                        echo '<ul class="nav nav-second-level collapse in">';
                                    }
                                    else
                                    {
                                        echo '<ul class="nav nav-second-level collapse">';
                                    }
                                ?>
                                    <li <?= Yii::$app->controller->id == "settings" || Yii::$app->controller->id == "archive" || Yii::$app->controller->module->id == "admin"  ? "class = activelink" : "" ?>><?=  Html::a('<span class="fa fa-cog"></span> CMS', ['/admin/settings'],['title' => 'Content Management System'])  ?></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li <?= Yii::$app->controller->id == "archive" ? "class = activelink" : "" ?>><?=  Html::a('<span class="fa fa-archive"></span> Archived', ['/admin/archive'])  ?></li>

                        <li>
                            <?php
                                echo Html::beginForm(['/user/logout'], 'post').Html::submitButton('<span class="glyphicon glyphicon-off"></span> Logout',['class' => 'btn btn-link logout']).Html::endForm();
                            ?>
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            
            <!-- /.navbar-static-side -->
        </nav>
        <?php } // is not Guest ?>
        <div id="page-wrapper" style="background-color: #ece8fd !important;">
            <!-- <div class="row"> -->
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Blank</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            <!-- </div> --> 
            <br/>
            <!-- /.row -->
            <?php
                if(Yii::$app->controller->module->id == "admin")
                {
                    echo Breadcrumbs::widget([
                        'homeLink' => [
                            'label' => 'Home',
                            'url' => Yii::getAlias('@web')."/admin/settings",
                        ],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]); 
                }
            ?>
            <?= Alert::widget() ?>
            <?= $content; ?>
        </div>
        <?php richardfan\widget\JSRegister::begin(); ?>
            <script>
                $('input.amountcomma').keyup(function(event) {
                  // skip for arrow keys
                    if(event.which >= 37 && event.which <= 40) return;
                  // format number
                    $(this).val(function(index, value) {
                    return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
                  });
                });
                // $("#side-menu").click(function(){
                //     $(".navbar-static-side").css({'margin-top':'0'});
                // });
            </script>
        <?php richardfan\widget\JSRegister::end(); ?>
        <!-- /#page-wrapper -->
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
