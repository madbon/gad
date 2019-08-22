<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\rms\models\UploadedClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploaded Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploaded-client-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Uploaded Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'region_c',
            'province_c',
            'citymun_c',
            //'first_name',
            //'middle_name',
            //'last_name',
            //'application_no',
            //'business_name',
            //'business_tin',
            //'application_date',
            //'date_uploaded',
            //'business_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
