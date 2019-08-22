<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\GadInnerCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'GAD Inner Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-inner-category-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create GAD Inner Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
