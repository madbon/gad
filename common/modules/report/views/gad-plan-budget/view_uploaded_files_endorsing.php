<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Gad Plan Budgets', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-plan-budget-view">
 <table class="table table-responsive table-hover table-striped" style="border:1px solid #7e57b1;">
    <thead>
        <tr>
            <th style="font-size: 18px; background-color: #7e57b1; color:white;" colspan="3">Uploaded File(s)</th>
        </tr>
    </thead>
    <tbody>
        
        <?php
            $folder_id = null;
            foreach ($qry as $key => $row) {
                if($folder_id != $row["folder_id"])
                {
                    echo 
                    "<tr>
                        <td style='font-size:18px; font-weight:bold;'>".$row['folder_title']."</td>
                        <td></td>
                        <td></td>
                    ";
                }

                if($row["extension"] == "jpeg" || $row["extension"] == "jpg" || $row["extension"] == "png" || $row["extension"] == "pdf")
                {
                    echo 
                    "<tr>
                        <td>".$row['file_name']."</td>
                        <td style='white-space:pre-line;'> ".(!empty($row['remarks']) ? "Remarks : ".$row['remarks'] : "")."</td>
                        <td>".(Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', ['view-uploaded-file', 'hash' => $row['hash'], 'extension' => $row['extension']], ['target' => '_blank','class'=>'btn btn-info btn-xs']))." ".
                        (Html::a('<span class="glyphicon glyphicon-download"></span> Download', ['download-uploaded-file', 'hash' => $row['hash'], 'extension' => $row['extension']], ['target' => '_blank','class'=>'btn btn-primary btn-xs']))." ".
                        ($row["user_id"] == Yii::$app->user->identity->id ? (Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', 
                            [
                                'delete-uploaded-file', 
                                'hash' => $row['hash'], 
                                'extension' => $row['extension'],
                                'ruc' => $ruc,
                                'onstep' => $onstep,
                                'tocreate' => $tocreate
                            ], 
                            [
                            'class'=>'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this file?',
                                'method' => 'post',
                            ],
                        ])) : "")."</td>";
                }
                else
                {
                    echo 
                    "<tr>
                        <td>".$row['file_name']."</td>
                        <td style='white-space:pre-line;'> ".(!empty($row['remarks']) ? "Remarks : ".$row['remarks'] : "")."</td>
                        <td>".(Html::a('<span class="glyphicon glyphicon-download"></span> Download', ['download-uploaded-file', 'hash' => $row['hash'], 'extension' => $row['extension']], ['target' => '_blank','class'=>'btn btn-primary btn-xs']))." ".
                        ($row["user_id"] == Yii::$app->user->identity->id ? (Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', 
                            [
                                'delete-uploaded-file', 
                                'hash' => $row['hash'], 
                                'extension' => $row['extension'],
                                'ruc' => $ruc,
                                'onstep' => $onstep,
                                'tocreate' => $tocreate
                            ], 
                            [
                            'class'=>'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this file?',
                                'method' => 'post',
                            ],
                        ])) : "")."</td>";
                }
                


                $folder_id = $row["folder_id"];
            } 
        ?>
    </tbody>
</table>
</div>
