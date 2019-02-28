<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\GadLeadResponsibleOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gad Lead Responsible Offices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-lead-responsible-office-index">
    <p>
        <?= Html::a('Create Gad Lead Responsible Office', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
