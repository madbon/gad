<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */

$this->title = 'BARANGAY : '.$model->barangayName;
$this->params['breadcrumbs'][] = ['label' => 'Barangays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drug-affectation-barangay-view">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-md-3">
            <table class="table table-responsive table-condensed table-hover table-bordered">
                <tr><th colspan="100%" class="th-title" style="padding-left:10px; background:#f7f7f7;">
                    Location</th>
                </tr> 
                <tr><td colspan="50%">Region</td>
                    <td colspan="50%"><?= $model->regionNameShort; ?></td>
                </tr>                        
                <tr><td colspan="50%">Province</td>
                    <td colspan="50%"><?= $model->provinceName; ?></td>
                </tr>                        
                <tr><td colspan="50%"><?= $model->citymun->lgu_type == "M" ? "Municipality" : "City" ; ?></td>
                    <td colspan="50%"><?= $model->citymunName; ?></td>
                </tr>                        
                <tr><td colspan="50%">Barangay</td>
                    <td colspan="50%"><?= $model->barangayName; ?></td>
                </tr>                        
                <tr><td colspan="50%">Year</td>
                    <td colspan="50%"><?= $model->year; ?></td>
                </tr>
                <tr><th colspan="100%" class="th-title" style="padding-left:10px; background:#f7f7f7;">
                    Punong Barangay</th>
                </tr> 
                <?php if($model->officialProfile) { ?>
                    <tr><td colspan="50%">Name</td>
                        <td colspan="50%"><?= $model->pbName; ?></td>
                    </tr>                        
                    <tr><td colspan="50%">Contact No.</td>
                        <td colspan="50%"><?= $model->mobileNo; ?></td>
                    </tr>                        
                    <tr><td colspan="50%">Address</td>
                        <td colspan="50%"><?= $model->address; ?></td>
                    </tr>                        
                    <tr><td colspan="50%">Term</td>
                        <td colspan="50%"><?= $model->term; ?></td>
                    </tr>  
                <?php } else { ?> 
                    <tr><td colspan="100%">
                        No available information.</td>
                    </tr> 
                <?php } ?>
            </table>
        </div>
        <div class="col-md-9">  
            <div class="box box-default">   
                <div class="box-body">

                <h4 class="page-header">INDICATORS</h4>

                    <table class="table table-responsive table-bordered" style="font-size:16px;">
                        <?php $cat = "";  
                        foreach($data as $d){ ?>
                            <?php if($cat != $d->category_title) { ?>
                                <tr style="background:#efefef; ">
                                    <th colspan="2" style="text-align:left;"><?= $d->category_title; ?></th>
                                </tr>
                            <?php } ?>
                        <?php 
                            if($d->type_title == "title") { ?>
                            <tr>
                                <th colspan=2 style="background:#fcfcfc;"><?= $d->indicator_title; ?></th>
                            </tr>
                            <?php } else if($d->type_title == "second-level-title") { ?>
                            <tr>
                                <th style="padding-left:30px;" colspan=2 style="background:#fff;"><?= $d->indicator_title; ?></th>
                            </tr>
                            <?php } else { ?>
                            <tr>
                                <td style="padding-left:60px;"><?= $d->indicator_title; ?></td>
                                <td>
                                    <?= $d->value;?>                            
                                        <?php if($d->subs){ ?>
                                            <?php foreach ($data2 as $sub) {
                                                if($sub->indicator_id == $d->indicator_id){
                                                    if($d->ans == $d->value) { ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:60px;"><?= $sub->sub_question; ?></td>
                                <td><?= $sub->value ? $sub->value : "" ; ?>
                                            <?php   }
                                                }
                                            } ?>
                                        <?php } ?>
                                </td>
                            </tr>
                            <?php }
                            $cat = $d->category_title;
                        } ?>
                    </table>

                    <br>

                </div>
            </div>
        </div>
    </div>
</div>
