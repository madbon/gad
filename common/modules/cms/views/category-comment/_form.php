<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadCategoryComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-category-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 3])->label("Input your comment(s) / recommendation(s) inside the box.") ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::$app->controller->action->id == "update" ? "Update" : "Add", ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
