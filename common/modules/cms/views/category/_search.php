<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<hr/>
<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    
    <?= $form->field($model, 'title')->label("Search Category Title") ?>
    <?php
    $url = \yii\helpers\Url::to(['dropdown-json/find-indicator-by-category-id']);
    echo $form->field($model, 'id')->widget(Select2::classname(), 
        [
            'data' => $category,
            'options' => ['placeholder' => '-'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Select Category Title");
    ?>
    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-filter"></span> &nbsp;Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('<span class="glyphicon glyphicon-refresh"></span> &nbsp;Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<hr/>
