<?php

namespace common\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\modules\cms\models\Category;
use common\modules\cms\models\Type;
use common\modules\cms\models\Unit;
use common\modules\cms\models\Indicator;
use common\modules\cms\models\CountryLatLong;
use common\modules\cms\models\PsgcCoordinators;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;

/**
 * HrisicontactinformationController implements the CRUD actions for HrisIContactInformation model.
 */
class DropdownJsonController extends Controller
{
    /**
     * 
     * @return mixed
     */

    public function actionGetCatContentTypeId($category_id)
    {

        $qry = Category::find()->where(['id'=>$category_id])->One();
        $res = !empty($qry->lgup_content_type_id) ? $qry->lgup_content_type_id : "";
       
        \Yii::$app->response->format = 'json';

        print_r($res); exit;
        return $res;
    }


    /**
     * 
     * @return mixed
     */

    public function actionFillCatSelectType($category_id)
    {

        if(Indicator::find()->where(['category_id'=>$category_id, 'unit_id'=>10])->exists())
        {
            $qry = Type::find()->where(['<>','id', 4])->all();
            $arr = [];
            $arr[] = ['id'=>'','text'=>''];
            foreach ($qry as  $Item) {
                $arr[] = [
                            'id' => $Item->id,
                            'text' => $Item->title,
                         ];
            }
            \Yii::$app->response->format = 'json';
        }
        else
        {

            $qry = Type::find()->all();
            $arr = [];
            $arr[] = ['id'=>'','text'=>''];
            foreach ($qry as  $Item) {
                $arr[] = [
                            'id' => $Item->id,
                            'text' => $Item->title,
                         ];
            }
            \Yii::$app->response->format = 'json';
        }

        return $arr;
    }

    /**
     * 
     * @return mixed
     */

    public function actionFillCatSelectUnit($category_id)
    {

        // if(Indicator::find()->where(['category_id'=>$category_id, 'unit_id'=>10])->exists())
        // {
        //     $qry = Unit::find()->where(['<>','id', 10])->all();
        //     $arr = [];
        //     $arr[] = ['id'=>'','text'=>''];
        //     foreach ($qry as  $Item) {
        //         $arr[] = [
        //                     'id' => $Item->id,
        //                     'text' => $Item->title,
        //                  ];
        //     }
        //     \Yii::$app->response->format = 'json';
        // }
        // else
        // {
            $qry = Unit::find()->all();
            $arr = [];
            $arr[] = ['id'=>'','text'=>''];
            foreach ($qry as  $Item) {
                $arr[] = [
                            'id' => $Item->id,
                            'text' => $Item->title,
                         ];
            }
            \Yii::$app->response->format = 'json';
        // }

        
        return $arr;
    }

    public function actionSelectedPlace($id)
    {
        $exploded = explode(",",$id);
        
        // Yii::$app->session['city_c'] = $exploded[0]; 
        // Yii::$app->session['prov_c'] = $exploded[1]; 
        // Yii::$app->session['reg_c'] = $exploded[2]; 

        // Yii::$app->response->redirect(['/dynamicview/find-place/public-view','region_c' => '00','province_c' => '00', 'citymun_c' => '00']);
    }

   
    public function actionFindPlace($q = null, $id = null) {


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
           

            $query1 = (new \yii\db\Query())
                ->select(["c.region_c", "c.province_c", "c.citymun_c", new \yii\db\Expression("CONCAT(c.citymun_m,', ',p.province_m, ', ',r.region_m) as title")])
                ->from('tblcitymun c')
                ->leftJoin(['p' => 'tblprovince'], 'p.province_c = c.province_c')
                ->leftJoin(['r' => 'tblregion'], 'r.region_c = c.region_c');

            $query2 = (new \yii\db\Query())
                ->select(["p.region_c", "p.province_c", new \yii\db\Expression("'' as citymun_c"), new \yii\db\Expression("CONCAT(r.region_m, ', ',p.province_m) as title")])
                ->from('tblprovince p')
                ->leftJoin(['r' => 'tblregion'], 'r.region_c = p.region_c');

            $query1->union($query2, true);

            $mainQuery = (new \yii\db\Query())
                        ->select([new \yii\db\Expression('CONCAT(x.citymun_c, ",", x.province_c, ",", x.region_c) as id'), 'x.title as text'])
                        ->from(['x' => $query1])
                        ->where(['like','x.title',$q])
                        ->orderBy(['x.region_c' => SORT_ASC, 'x.province_c' =>SORT_ASC,'x.citymun_c'=>SORT_ASC]);


            $command = $mainQuery->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            // print_r($id); exit;
           
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>  HrisIPersonalInfo::find($id)->sname.', '.HrisIPersonalInfo::find($id)->fname.' '.HrisIPersonalInfo::find($id)->mname];
        }
        return $out;
    }

    public function actionFindPlaceByRegProv($q = null, $id = null, $choose = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) { 
           
                $query = (new Query())
                ->select([
                            "CONCAT(00,',',PC.province_c,',',RC.region_c) as id,CONCAT(PC.province_m, ', ',RC.region_m) as text",
                         ])
                ->from('tblcitymun CC')
                ->leftJoin(['RC' => 'tblregion'], 'RC.region_c = CC.region_c')
                ->leftJoin(['PC' => 'tblprovince'], 'PC.province_c = CC.province_c')
                ->where(['like','RC.region_m',$q])
                ->orWhere(['like','PC.province_m',$q])
                ->groupBy('PC.province_c')
                ->limit(20);


            

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            // print_r($id); exit;
           
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>  HrisIPersonalInfo::find($id)->sname.', '.HrisIPersonalInfo::find($id)->fname.' '.HrisIPersonalInfo::find($id)->mname];
        }
        return $out;
    }

    public function actionFindProvinceByRegion($region_c)
    {
        $qry = Province::find()->where(['region_c'=>$region_c])->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->province_c,
                        'text' => $Item->province_m,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindCitymunByProvince($region_c,$province_c)
    {
        $qry = Citymun::find()->where(['region_c'=>$region_c])->andWhere(['province_c'=>$province_c])->distinct()->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->citymun_c,
                        'text' => $Item->citymun_m,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindCategoryBySort($applicable_to)
    {
        $qry = Category::find()->where(['applicable_to'=>$applicable_to])->orderBy(['sort' => SORT_ASC])->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->sort,
                        'text' => 'After '.$Item->title,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindIndicatorByCategoryId($category_id)
    {
        $qry = Indicator::find()->where(['category_id'=>$category_id])->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->id,
                        'text' => 'After '.$Item->title,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionSessionRegProvCity($region_c, $province_c, $citymun_c)
    {
        Yii::$app->session['city_c'] = $citymun_c;
        Yii::$app->session['prov_c'] = $province_c; 
        Yii::$app->session['reg_c'] = $region_c; 
    }

    public function actionLoadJson($region_c,$citymun_c,$province_c)
    {
        $condition = [];
        if($province_c == "" && $citymun_c == "")
        {
            $condition = ['x.region_c' => $region_c];
        }
        else if($province_c != "" && $citymun_c == "")
        {
            $condition = ['x.region_c' => $region_c, 'x.province_c' => $province_c];
        }
        else
        {
            $condition = ['x.region_c' => $region_c, 'x.province_c' => $province_c, 'x.citymun_c' => $citymun_c];
        }

         $query1 = (new Query())
                ->select([
                            "R.region_m",
                            "P.province_m",
                                new \yii\db\Expression(" '' as citymun_m"),
                            new \yii\db\Expression(" '' as citymun_c"),
                            new \yii\db\Expression(" '' as province_c"),
                            new \yii\db\Expression(" '' as region_c"),
                            "L.lat",
                            "L.lng",
                         ])
                ->from('tblprovince P')
                ->leftJoin(['R' => 'tblregion'], 'R.region_c = P.region_c')
                ->leftJoin(['L' => 'tblinformation_latlng'], 'L.region_c = P.region_c AND L.province_c = P.province_c AND L.citymun_c = ""');

        // echo "<pre>";
        // print_r($query1->all()); exit;

        $query2 = (new Query())
                ->select([
                            "R.region_m",
                            "P.province_m",
                            "C.citymun_m",
                            "C.citymun_c",
                            "P.province_c",
                            "R.region_c",
                            "L.lat",
                            "L.lng",
                         ])
                ->from('tblcitymun C')
                ->leftJoin(['R' => 'tblregion'], 'R.region_c = C.region_c')
                ->leftJoin(['P' => 'tblprovince'], 'P.region_c = C.region_c AND P.province_c = C.province_c')
                ->leftJoin(['L' => 'tblinformation_latlng'], 'L.region_c = C.region_c AND L.province_c = C.province_c AND L.citymun_c = C.citymun_c AND L.citymun_c != ""');

        $query1->union($query2, true);

        $mainQuery = (new \yii\db\Query())
                        ->select([new \yii\db\Expression('x.region_m as RegionName, x.province_m as ProvinceName, x.citymun_m as CitymunName, x.lat as lat, x.lng as lng, x.region_c as RegionCode, x.province_c as ProvinceCode, x.citymun_c as CitymunCode')])
                        ->from(['x' => $query1])
                        ->where($condition)
                        ->all();
       

                
        $arr = [];

        foreach ($mainQuery as  $Item) {
            $arr[] = [
                        'region_name' => $Item["RegionName"],
                        'province_name' => $Item["ProvinceName"],
                        'citymun_name' => $Item["CitymunName"],
                        'region_code' => $Item["RegionCode"],
                        'province_code' => $Item["ProvinceCode"],
                        'citymun_code' => $Item["CitymunCode"],
                        'lat' => $Item["lat"],
                        'lng' => $Item["lng"],

                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

}
?>
