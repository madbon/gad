<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadLeadResponsibleOffice */

$this->title = 'Update Gad Lead Responsible Office: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Gad Lead Responsible Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-lead-responsible-office-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
