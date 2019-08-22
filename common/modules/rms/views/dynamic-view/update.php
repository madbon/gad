<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */

$this->title = 'Update Barangay ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barangays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="drug-affectation-barangay-update">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
		'contentExtension' => $contentExtension,
		'contentValue' => $contentValue,
        'model' => $model,
        'data' => $data,
        'data2' => $data2,
    ]) ?>

</div>


<?php
    $this->registerJs('
        $( "#step2btn" ).click(function() {
            $( ".btn" ).trigger( "click" );
        });
    ')
?>