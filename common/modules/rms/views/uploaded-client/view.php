<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\rms\models\UploadedClient */

$this->title = $model->business_name;
$this->params['breadcrumbs'][] = ['label' => 'Registered Business', 'url' => ['/rms/dynamic-view/registered-business']];
$this->params['breadcrumbs'][] = $model->business_name;
\yii\web\YiiAsset::register($this);
?> 
<div class="box box-primary">
    <div class="box-body">
        <div class="row">   
            <p style="margin-left: 14px;font-size: 16px;"><strong><?= $model->business_name ?></strong></p> 
            <div class="col-md-12">     
                <hr style="border: 1px solid #d2d6de;margin-top: -3px;">   
            </div> 
        <div class="col-md-12">
            <div class="uploaded-client-view">
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this record?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'first_name',
                        'middle_name',
                        'last_name',
                        'application_no',
                        'business_name',
                        'business_tin',
                        'application_date',
                        'date_uploaded',
                        'businessType.description',
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
