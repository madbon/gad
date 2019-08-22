<?php 
use yii\helpers\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= Html::img('@web/user.png', ['alt' => 'User Image', 'class' => 'img-circle']) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->profile->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php 
            $menuItems = [
                // [
                //     'label' => 'Mailbox', 'icon' => 'envelope-o', 'url' => ['/mailbox'],
                //     'template'=>'<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">123</small></span></a>'
                // ],
                ['label' => 'Dashboard', 'icon' => 'tachometer', 'url' => ['/']],
            ];

            if (YII_ENV == 'dev') {
                
                $debugItems = [
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'LGU Information', 'icon' => 'file', 'url' => ['/dynamicview/dynamic-view/index']],
                    ['label' => 'Notifications (Report)', 'icon' => 'bell', 'url' => ['#']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                ];

                foreach ($debugItems as $d) {
                    array_push($menuItems, $d);
                }
            }
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menuItems
            ]
        ) ?>

    </section>

</aside>
