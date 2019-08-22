<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url; 
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use common\models\LasVlDates;
use yii\widgets\Breadcrumbs;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LasAppLeave */
?>
<div class="row">
    <div class="col-lg-12">
    <?php if(!empty($extension) && !empty($file)){ ?>
        <h5><strong>File Preview:</strong></h5>
        <?php if($extension =='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='bmp'){ ?>  
        <?php if(basename(Yii::getAlias('@app')) == "backend"){ ?>  
            <?= Html::img(\Yii::$app->urlManagerFrontend->baseUrl.'/uploads/forms/'.$file, ['alt'=>'images','class'=>'img-responsive']); ?>
        <?php }else{ ?>             
            <?= Html::img(Url::base().'/uploads/forms/'.$file, ['alt'=>'images','class'=>'img-responsive']); ?>
        <?php } ?>
            <hr>
            <?php if(basename(Yii::getAlias('@app')) == "frontend"){ ?>  
                <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Remove Attachment', 
                             ['remove-attachment','id'=>$model->id, 'uid' => $model->hash], 
                             ['class' => 'btn btn-sm btn-danger',
                             'data' => ['confirm' => 'Are you sure you want to remove this attachment?','method' => 'post']]) 
                ?>
            <?php } ?>
        <?php }else if($extension=='pdf'){ ?>
        <?php if(basename(Yii::getAlias('@app')) == "backend"){ ?>  
            <iframe src="<?= \Yii::$app->urlManagerFrontend->baseUrl.'/uploads/forms/'.$file ?>" width="100%" height="600px;"></iframe>
        <?php }else{ ?>
            <iframe src="<?= Url::base().'/uploads/forms/'.$file ?>" width="100%" height="600px;"></iframe>
        <?php }?>     
            
            <hr>
            <?php if(basename(Yii::getAlias('@app')) == "frontend"){ ?>  
                <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Remove Attachment', 
                             ['remove-attachment','id'=>$model->id, 'uid' => $model->hash], 
                             ['class' => 'btn btn-sm btn-danger',
                             'data' => ['confirm' => 'Are you sure you want to remove this attachment?','method' => 'post']]) 
                ?>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <?php if(basename(Yii::getAlias('@app')) == "frontend"){ ?>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <?php echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [

                    'pluginOptions' => [
                        'browseClass' => "btn btn-primary btn-file",
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Browse',
                        'maxFileCount' => 5,
                        'allowedFileExtensions' => ["png", "jpg", "jpeg", "bmp", "pdf"],
                    ],
                    'options'=>[
                        'multiple'=>false,
                    ],
                ]); ?>
                <hr style="border: 1px solid #d2d6de;margin-top: 10px;">
                <button class="btn btn-sm btn-success pull-right"><i class="glyphicon glyphicon-upload"></i> Upload</button>
                <br><br>
            <?php ActiveForm::end(); ?>
        <?php } ?>
    <?php } ?>
    </div>  
</div>