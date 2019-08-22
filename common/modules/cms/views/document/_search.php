<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\DocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'frequency') ?>

    <?= $form->field($model, 'frequency_id') ?>

    <?= $form->field($model, 'lgup_content_type_id') ?>

    <?php // echo $form->field($model, 'lgup_content_width_id') ?>

    <?php // echo $form->field($model, 'applicable_to') ?>

    <?php // echo $form->field($model, 'left_or_right') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'add_comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
