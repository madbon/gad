<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadReportHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'REPORT HISTORY';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-report-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?php // Html::a('Create Gad Report History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 -->
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'tuc',
                'date_created',
                'time_created',
                'status',
                'remarks:ntext',
                'fullname',
                'responsible_office_c',
                'responsible_user_id',
                'responsible_region_c',
                'responsible_province_c',
                'responsible_citymun_c',
                
                

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>
</div>
