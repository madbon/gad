<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GadReportHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Report Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-report-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'remarks:ntext',
            'tuc',
            'status',
            'responsible_office_c',
            'responsible_user_id',
            'responsible_region_c',
            'responsible_province_c',
            'responsible_citymun_c',
            'fullname',
            'date_created',
            'time_created',
        ],
    ]) ?>

</div>
