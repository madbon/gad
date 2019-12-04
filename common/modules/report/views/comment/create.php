<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadComment */

$this->title = "Create Specific Observations and Recommendations";
// $this->params['breadcrumbs'][] = ['label' => 'Gad Comments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-comment-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'ruc' => $ruc,
        'controllerid' => $controllerid,
        'plan_id' => $plan_id,
        'row_no' => $row_no,
        'column_no' => $column_no,
        'attribute_name' => $attribute_name,
        'column_title' => $column_title,
    ]) ?>

</div>
