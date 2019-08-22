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
    <center>
    <div class="steps-form-2" style="margin: 50px 0 50px 0;">
        <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
            <div class="steps-step-2">
            	<?= Html::a('<i class="glyphicon glyphicon-user" aria-hidden="true" id="headerIcon"></i>', ["create"], 
            				[
            					'class' => 'btn btn-circle-2 waves-effect ml-0 btn-blue-grey btn-amber',
            					'type' => 'button',
            					'data-toggle' => 'tooltip',
            					'data-placement' => 'top',
            					'data-original-title' => "Basic Information"

            				]) ?>
            </div>
            <div class="steps-step-2">
                <a href="#step-2" type="button" class="btn btn-blue-grey btn-circle-2-1 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Personal Data">
                    <i class="glyphicon glyphicon-pencil aria-hidden="true" id="headerIcon"></i></a>
            </div>
            <div class="steps-step-2">
                <a href="#step-3" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Terms and Conditions">
                    <i class="glyphicon glyphicon-ok" aria-hidden="true" id="headerIcon"></i></a>
            </div>
        </div>
    </div>
    </center>
    <!-- <h3><b>&nbsp;&nbsp;Survey</b></h3> -->
    <div class="box-body">    
        <?= $this->render('_form_content', [
			'contentExtension' => $contentExtension,
			'contentValue' => $contentValue,
            'session' => $session,
            'data' => $data,
            'data2' => $data2,
            'regm' => $regm,
            'prvm' => $prvm,
            'cmm' => $cmm,
            'model' => $model,
            'withData' => $withData,
        ]) ?>
    </div>
</div>
