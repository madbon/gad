<?php

namespace common\modules\report\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadRecord;
use yii\db\Query;
use Yii;
use yii\db\Expression;
use \common\modules\report\controllers\DefaultController as Tools;
/**
 * GadRecordSearch represents the model behind the search form of `common\models\GadRecord`.
 */
class GadRecordSearch extends GadRecord
{
    /**
     * {@inheritdoc}
     */
    public $record_tuc;
    public function rules()
    {
        return [
            [['id', 'user_id', 'region_c', 'province_c', 'citymun_c', 'year', 'form_type', 'status', 'is_archive'], 'integer'],
            [['total_lgu_budget', 'total_gad_budget'], 'number'],
            [['date_created', 'time_created','record_tuc','report_type_id','plan_type_code'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        $filteredByRole = [];

        $filteredByRoleArchive = [];
        
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,'GR.status'=>Tools::ViewStatus($this->report_type_id == 1 ? 'gad_lgu_huc' : 'ar_filtered_status_huc')];

                $filteredByRoleArchive = [
                    'GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
                    'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,
                    'GR.status'=>array_merge(Tools::ViewStatus('gad_lgu_huc'),Tools::ViewStatus('ar_filtered_status_huc')),  
                ];
            }
            else
            {
                $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,'GR.status' => Tools::ViewStatus($this->report_type_id == 1 ? 'gad_lgu_non_huc' : 'ar_filtered_status_lgu_ccm')];

                $filteredByRoleArchive = [
                    'GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
                    'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,
                    'GR.status' => array_merge(Tools::ViewStatus('gad_lgu_non_huc'),Tools::ViewStatus('ar_filtered_status_lgu_ccm'))
                ];
            }
        }
        else if(Yii::$app->user->can("gad_field_permission"))
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        else if(Yii::$app->user->can("gad_province_permission")) // all lower level lgu under its province
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.status'=>Tools::ViewStatus($this->report_type_id == 1 ? 'gad_province_dilg' : 'ar_filtered_status_province_dilg')];

            $filteredByRoleArchive = [
                'GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
                'GR.status'=> array_merge(Tools::ViewStatus('gad_province_dilg'),Tools::ViewStatus('ar_filtered_status_province_dilg'))
            ];
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission")) // all plan submitted by this province
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
            'GR.status' => Tools::ViewStatus($this->report_type_id == 1 ? 'gad_province_lgu' : 'ar_filtered_status_lgu_province'),'GR.office_c' => 2];

            $filteredByRoleArchive = [
                'GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
                'GR.status' => array_merge(Tools::ViewStatus('gad_province_lgu'),Tools::ViewStatus('ar_filtered_status_lgu_province')),
                'GR.office_c' => 2
            ];
        }
        else if(Yii::$app->user->can("gad_region_permission"))
        {
            $filteredByRole = ['GR.region_c' => Yii::$app->user->identity->userinfo->REGION_C,'GR.status' =>  Tools::ViewStatus($this->report_type_id == 1 ? 'gad_region_dilg' : 'ar_filtered_status_region')];

            $filteredByRoleArchive = [
                'GR.region_c' => Yii::$app->user->identity->userinfo->REGION_C,
                'GR.status' => array_merge(Tools::ViewStatus('gad_region_dilg'),Tools::ViewStatus('ar_filtered_status_region'))    
            ];
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.status'=> Tools::ViewStatus($this->report_type_id == 1 ? 'gad_ppdo' : 'ar_filtered_status_ppdo')];

            $filteredByRoleArchive = [
                'GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
                'GR.status'=> array_merge(Tools::ViewStatus('gad_ppdo'),Tools::ViewStatus('ar_filtered_status_ppdo'))
            ];
        }
        else
        {
            $filteredByRole = [];
        }

       

        $query = (new Query())
        ->select([
            'REG.region_m as region_name',
            'PROV.province_m as province_name',
            'CTY.citymun_m as citymun_name',
            'GR.total_lgu_budget as record_total_lgu_budget',
            'GR.total_gad_budget as record_total_gad_budget',
            'GR.status as record_status',
            'GR.year as record_year',
            'GR.tuc as record_tuc',
            'GR.date_created as record_date',
            'GR.time_created as record_time',
            'GR.form_type as record_form_type',
            'CONCAT(UI.FIRST_M, " ",UI.LAST_M) as responsbile',
            'GR.id as record_id',
            'OFC.OFFICE_M as office_name',
            'GR.date_created',
            'GR.report_type_id',
            'PT.title as plan_type_title'
        ])
        ->from('gad_record GR')
        ->leftJoin(['UI' => 'user_info'], 'UI.user_id = GR.user_id')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = GR.province_c')
        ->leftJoin(['CTY' => 'tblcitymun'], 'CTY.citymun_c = GR.citymun_c and CTY.province_c = GR.province_c')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GR.office_c')
        ->leftJoin(['PT' => 'gad_plan_type'], 'PT.code = GR.plan_type_code')
        // ->leftJoin(['HIST' => 'gad_report_history'],'HIST.tuc = GR.tuc')
        ->where(Yii::$app->controller->id == "archive" ? $filteredByRoleArchive : $filteredByRole)
        ->andWhere(['GR.is_archive' => Yii::$app->controller->id == "archive" ? 1 : 0])
        ->andFilterWhere(['LIKE','GR.tuc',$this->record_tuc])
        ->andFilterWhere(['GR.region_c' => $this->region_c])
        ->andFilterWhere(['GR.province_c' => $this->province_c])
        ->andFilterWhere(['GR.citymun_c' => $this->citymun_c])
        ->andFilterWhere(['GR.status' => $this->status])
        ->andFilterWhere(['GR.year' => $this->year])
        ->andFilterWhere(['GR.plan_type_code' => $this->plan_type_code])
        ->groupBy(['GR.id'])
        ->orderBy(['GR.id' => SORT_DESC]);

        // print_r($query->createCommand()->rawSql); exit;
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    // 'pageSize' => ,
                ],
        ]);

        Yii::$app->session["GadRecordSearch"] = $dataProvider;

        return $dataProvider;
    }
}
