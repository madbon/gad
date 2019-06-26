<?php

namespace common\modules\rms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\rms\models\Record;

/**
 * RecordSearch represents the model behind the search form of `common\modules\businesspermit\models\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'form_type'], 'integer'],
            [['region_c','province_c', 'citymun_c', 'barangay_c', 'first_name', 'middle_name', 'last_name', 'application_no', 'application_date', 'contact_no', 'email_address', 'date_added', 'application_type','user_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        if(Yii::$app->user->can('LGUP_SuperAdministrator')){
            $query = Record::find();
            if(Yii::$app->controller->action->id == 'view'){                
                $userRegion = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : '00';
                $userProvince = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : '00';
                $userCitymun = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : '00';
                $query = Record::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince, 'citymun_c' => $userCitymun, 'form_type' => $params['cat']]);
            }
        }
        else if(Yii::$app->user->can('LGUP_Approver')){
            $sQuery = Record::find()->select(['MAX(id) as id'])->groupBy(['region_c','province_c','citymun_c','form_type']);
            $query = Record::find()->where(['in', 'id', $sQuery]);
            if(Yii::$app->controller->action->id == 'view'){                
                $userRegion = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : '00';
                $userProvince = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : '00';
                $userCitymun = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : '00';
                $query = Record::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince, 'citymun_c' => $userCitymun, 'form_type' => $params['cat']]);
            }
        }
        else if(Yii::$app->user->can('bpls_fo')){
            $sQuery = Record::find()->select(['MAX(id) as id'])->groupBy(['region_c','province_c','citymun_c','form_type']);
            $query = Record::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['in', 'id', $sQuery]);
            if(Yii::$app->controller->action->id == 'view'){                
                $userRegion = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : '00';
                $userProvince = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : '00';
                $userCitymun = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : null;
                $query = Record::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince, 'citymun_c' => $userCitymun, 'form_type' => $params['cat']]);
            }
        }
        else{
            $query = Record::find();
        }
        


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'application_date' => $this->application_date,
            'date_added' => $this->date_added,
            'form_type' => $this->form_type,
        ]);

        $query->andFilterWhere(['like', 'region_c', $this->region_c])
            ->andFilterWhere(['like', 'province_c', $this->province_c])
            ->andFilterWhere(['like', 'citymun_c', $this->citymun_c])
            ->andFilterWhere(['like', 'barangay_c', $this->barangay_c])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'application_no', $this->application_no])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'application_type', $this->application_type]);

        return $dataProvider;
    }
}
