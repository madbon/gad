<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Plan Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-plan-budget-view">
 <table class="table table-responsive">
    <tbody>
        <tr>
            <td>
                <label class="label-control"><i class="fa fa-download"></i> Download attachment(s) here</label>
                <?= \file\components\AttachmentsTable::widget(['model' => $model]) ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="rpw">
                    <?php
                    $file = "";
                    // print_r($model->files); exit;
                    foreach ($model->files as $file) { ?>

                        <div class="col-sm-6">
                            <?php 
                                // $file = "/gad/backend/web/file/file/download?id=".$file->id;
                                $file = Url::base()."/file/file/download?id=".$file->id;
                                echo Html::img($file,['width' => '100%', 'height' => 'auto','class' => 'img-responsive']);
                            ?>
                        </div>
                    <?php }  ?>
                </div>
            </td>
        </tr>
        
    </tbody>
</table>
</div>
