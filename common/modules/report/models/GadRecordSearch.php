<?php

namespace common\modules\report\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadRecord;
use yii\db\Query;
use Yii;
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
            [['date_created', 'time_created','record_tuc'], 'safe'],
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
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        elseif(Yii::$app->user->can("gad_field_permission"))
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        else if(Yii::$app->user->can("gad_province_permission") || Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $filteredByRole = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'GR.citymun_c' => NULL,'GR.office_c' => 2];
        }
        else if(Yii::$app->user->can("gad_region"))
        {
            $filteredByRole = ['GR.region_c' => Yii::$app->user->identity->userinfo->REGION_C];
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
            'OFC.OFFICE_M as office_name'
            // 'HIST.remarks as remarks'
        ])
        ->from('gad_record GR')
        ->leftJoin(['UI' => 'user_info'], 'UI.user_id = GR.user_id')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = GR.province_c')
        ->leftJoin(['CTY' => 'tblcitymun'], 'CTY.citymun_c = GR.citymun_c and CTY.province_c = GR.province_c')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GR.office_c')
        // ->leftJoin(['HIST' => 'gad_report_history'],'HIST.tuc = GR.tuc')
        ->andFilterWhere(['LIKE','GR.tuc',$this->record_tuc])
        ->andFilterWhere($filteredByRole)
        ->groupBy(['GR.id'])
        ->orderBy(['GR.id' => SORT_DESC]);

        // print_r($query->createCommand()->rawSql); exit;
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' =>  10,
                ],
        ]);

        return $dataProvider;
    }
}
