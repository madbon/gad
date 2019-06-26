<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\bis\models\FrequencyDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Frequency Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequency-details-index">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="form-group pull-right">
        <?= Html::a('Create Frequency Details', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table table-condensed table-responsive table-hovered table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'frequency_id',
            'details',

            ['class' => 'yii\grid\ActionColumn'],
        ],  
        'layout' => "{items}\n<div class='text-info text-right'>{summary}</div>\n{pager}",
    ]); ?>
</div>
