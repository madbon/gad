<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadLeadResponsibleOffice */

$this->title = 'Create Gad Lead Responsible Office';
$this->params['breadcrumbs'][] = ['label' => 'Gad Lead Responsible Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-lead-responsible-office-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
