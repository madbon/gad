<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url; 
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use common\models\LasVlDates;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\LasAppLeave */
$this->title = 'Attachments';
$this->params['breadcrumbs'][] = ['label' => 'List of LGU Information Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['view', 'id' => $id2, 'cat' => $cat]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
    <h5><strong>File Preview:</strong></h5>
    <div class="row">
    <?php foreach ($model as $key => $row): ?>
        <?php if($row->type =='png' || $row->type=='jpg' || $row->type=='jpeg' || $row->type=='bmp'){ ?>            
            <div class="col-lg-2">
                <div class="box box-default">   
                    <div class="box-body">                
                        <?= Html::img(Url::base().'/uploads/'.$row->filename, ['alt'=>'images','class'=>'img-responsive']); ?>
                    </div>
                    <div class="box-footer" style="background-color: #d2d6de;">   
                        <center><p style="font-size: 12px;word-wrap: break-word;width: 100px;cursor: pointer;" title="<?= $row->filename ?>" class="label label-primary">Hover to view filename</p></center>
                    </div>
                </div>
            </div>
        <?php }else if($row->type=='pdf'){ ?>            
            <div class="col-lg-12">
                <div class="box box-default">   
                    <div class="box-body">
                        <?= \yii2assets\pdfjs\PdfJs::widget([
                            'height'=> '1000px',
                            'url'=> Url::base().'/uploads/'.$row->filename
                        ]); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endforeach; ?>
    </div>
    </div>  
</div>