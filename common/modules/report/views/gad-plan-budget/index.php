<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gad Plan Budgets (Annex A)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-plan-budget-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Annex A', ['gad-record/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-responsive table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>Gender Issue / Gender Mandate</th>
                <th>GAD Objective</th>
                <th>Relevant LGU Program or Project</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $form = ActiveForm::begin();
                $issue_mandate = null;
                $url = \yii\helpers\Url::to(['/report/default/update-objective']);
                foreach ($dataProvider as $key => $val) {
                    echo "
                        <tr>
                            <td>".($issue_mandate != $val['issue_mandate'] ? $val['issue_mandate'] : '')."</td>
                            <td>".'<p id=disp-text-'.$val['id'].'>'.$val['objective'].'</p>'.($form->field($val,'objective')->textarea(['rows' => 6, 'class' => 'input-'.$val['id']])->label(false))."<button type='button' class='btn btn-primary btn-xs' title='Update' id='btnobj-".$val['id']."'><span class='glyphicon glyphicon-floppy-disk'></span></button>"."</td>
                            <td>".$val['relevant_lgu_program_project']."</td>
                            <td>".(Html::a('Edit', ['update', 'id' => $val['id']], ['class' => 'btn btn-success']))."</td>
                        </tr>
                    ";

                    $this->registerJs('
                        $("#btnobj-'.$val['id'].'").click(function(){
                            var id = '.$val['id'].';
                            var obj_val = $(".input-'.$val["id"].'").val();
                            $.ajax({
                                url: "'.$url.'",
                                data: { 
                                        id:id,
                                        obj_val:obj_val
                                        }
                                
                                }).done(function(result) {
                                 $("#disp-text-'.$val["id"].'").text(result);
                                
                            });
                      }); 
                    ');
                    $issue_mandate = $val['issue_mandate'];
                } 
                ActiveForm::end();
            ?>
        </tbody>
    </table>
</div>

<?php
// $issue_mandate = null;
// echo GridView::widget([
//         'dataProvider' => $dataProvider,
//         'options' => ['class' => 'table table-responsive'],
//         // 'filterModel' => $searchModel,
//         'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             // 'id',
//             // 'user_id',
//             // 'region_c',
//             // 'province_c',
//             // 'citymun_c',
//             // 'issue_mandate:ntext',
//             [
//                 'label' => 'Issue Mandate',
//                 'attribute' => 'issue_mandate',
//                 'value' => function($model)
//                 {

//                 }
//             ],
//             'objective:ntext',
//             'relevant_lgu_program_project:ntext',
//             'activity:ntext',
//             'performance_indicator_target:ntext',
//             'budget_mooe',
//             'budget_ps',
//             'budget_co',
//             'lead_responsible_office_id',
//             //'date_created',
//             //'time_created',
//             //'date_updated',
//             //'time_updated',
//             //'sort',
//             //'tuc_parent',

//             ['class' => 'yii\grid\ActionColumn'],
//         ],
//     ]); 

?>