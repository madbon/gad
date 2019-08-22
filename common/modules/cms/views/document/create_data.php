<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */

// $this->title = Yii::$app->controller->action->id == "add-data" ? 'Add Data for '.$model->citymunName : 'Update Data for '.$model->citymunName;
// $this->params['breadcrumbs'][] = ['label' => 'List of LGU Information Forms', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    #headerIcon {
        font-size: 30px;
        margin-top: -5px;
    }
    .glyphicon-pencil{
        color: white;
    }
    .btn-circle-2-1 {
        width: 70px;
        height: 70px;
        border: 2px solid #59698D;
        background-color: #59698D !important;
        color: #59698D !important;
        border-radius: 50%;
        padding: 22px 18px 15px 18px;
        margin-top: -22px;
    }
</style>
<div class="survey-create">
   
    <div class="box-body">    
        <?= $this->render('_form_content', [
			// 'contentExtension' => $contentExtension,
			// 'contentValue' => $contentValue,
            // 'session' => $session,
            'data' => $data,
            'data2' => $data2,
            'ruc' => $ruc,
            // 'regm' => $regm,
            // 'prvm' => $prvm,
            // 'cmm' => $cmm,
            // 'model' => $model,
            // 'withData' => $withData,
        ]) ?>
    </div>
</div>
