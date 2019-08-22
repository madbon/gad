<?php

namespace common\modules\cms\controllers;

use Yii;
use common\modules\cms\models\Indicator;
use common\modules\cms\models\IndicatorSearch;
use common\modules\cms\models\ChoiceWithSubQuestion;
use common\modules\cms\models\DefaultChoice;
use common\modules\cms\models\SubQuestion;
use common\modules\cms\models\Choice;
use common\modules\cms\models\Category;
use common\modules\cms\models\Type;
use common\modules\cms\models\Frequency;
use common\modules\cms\models\Unit;
use common\modules\cms\models\Value;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\MultipleModel;
use niksko12\auditlogs\classes\ControllerAudit;
use yii\filters\AccessControl;
use common\models\Record;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use niksko12\user\models\Barangay;
use yii\base\Model;

/**
 * Indicator1Controller implements the CRUD actions for Indicator model.
 */
class IndicatorController extends ControllerAudit
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    

    /**
     * Lists all Indicator models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IndicatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $default = [];
        $category = ArrayHelper::map(Category::find()->select(['id','title'])->all(), 'id', 'title');
        $indicator = ArrayHelper::map(Indicator::find()->where(['category_id' => $searchModel->category_id])->select(['id','title'])->all(), 'id', 'title');
        $indicator2 = ArrayHelper::map(Indicator::find()->select(['id','title'])->all(), 'id', 'title');
        $unit = ArrayHelper::map(Unit::find()->select(['id','title'])->all(), 'id', 'title');
        $type = ArrayHelper::map(Type::find()->select(['id','title'])->all(), 'id', 'title');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'default' => $default,
            'category' => $category,
            'unit' =>  $unit,
            'type' => $type,
            'indicator' => $indicator,
            'indicator2' => $indicator2,
        ]);
    }

    /**
     * Displays a single Indicator model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $subquestions = [new SubQuestion];
        $cs = new ChoiceWithSubQuestion();


        $units = Unit::find()->where(['and',
           ['<>','id', 1],
           ['<>','id', 7]
       ])->all();
        $units = ArrayHelper::map($units,'id','title');

        $chs = $model->choices;
        $chs = ArrayHelper::map($chs,'value','value');

        if ($cs->load(Yii::$app->request->post())) {

            $subquestions = [];

            if(Yii::$app->request->post('SubQuestion'))
            {
                foreach(Yii::$app->request->post('SubQuestion') as $key=>$val)
                {
                    $subquestions[$key] = new SubQuestion;
                }
            }


                MultipleModel::loadMultiple($subquestions, Yii::$app->request->post());

                // validate all models
                $modelValidation = $cs->validate();
                $valid = MultipleModel::validateMultiple($subquestions) && $modelValidation;
                if ($valid) {
                    try {
                            $transaction = \Yii::$app->db->beginTransaction();

                            $cs->indicator_id = $model->id;
                            $cs->save();

                            if ($flag = $cs->save(false)) 
                            {
                                foreach($subquestions as $subquestion) 
                                {
                                    if($subquestion->sub_question != ""){
                                        $subquestion->indicator_id = $model->id;
                                        if (! ($flag = $subquestion->save(false))) 
                                        {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }
                                }
                            }

                            if ($flag) 
                            {
                                $transaction->commit();
                                return $this->redirect(['view', 'id' => $model->id]);
                            }
                            return $this->redirect(['view', 'id' => $model->id]);
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    } 
                }
        } else {
            return $this->render('view', [
                'model' => $model,
                'subquestions' => $subquestions,
                'units' => $units,
                'cs' => $cs,'chs' => $chs,
            ]);
        }
    }

    /**
     * Creates a new Indicator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Indicator();
        $categories = Category::find()->all();
        $categories = ArrayHelper::map($categories,'id','title');
        $types = Type::find()->all();
        $types = ArrayHelper::map($types,'id','title');
        $units = Unit::find()->where(['<>', 'id', 1])->all();
        $units = ArrayHelper::map($units,'id','title');
        $frequencies = Frequency::find()->all();
        $frequencies = ArrayHelper::map($frequencies,'id','title');
        $dchoices = DefaultChoice::find()->orderBy(['id' => SORT_DESC])->all();
        $dchoices = ArrayHelper::map($dchoices,'id','title');

        $in_chart = [0 => "No", 1 => "Yes"];

        $choices = [new Choice];

        if ($model->load(Yii::$app->request->post())) {

            

                if(Indicator::find()->where(['category_id' => $model->category_id, 'unit_id' => 10])->exists()) // if file_attachment is exist in indicator
                {
                    
                    
                    // if($model->type_id == 4 || $model->unit_id == 10)
                    // {
                    //     throw new \yii\web\HttpException(403, 'The category has already a file attachment widget.');
                    // }
                    // else
                    // { 
                        
                        if($model->default_choice_id != 1){
                            if($model->type_id == 1 || $model->type_id == 3 || $model->type_id == 4)
                            {
                                $model->unit_id = null;
                            }
                            $model->save();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                        else 
                        { // else start_1 

                            if($model->temp_content_type_id == 9 || $model->temp_content_type_id == 10) // bar and line graph
                            {
                                $model->type_id = 2;
                                $model->unit_id = 7;
                                $model->default_choice_id = 1;
                            }
                            else if($model->temp_content_type_id == 8)
                            {
                                $model->type_id = 2;
                                $model->unit_id = 8;
                            }
                            $ans = $model->answer_with_question;

                            $choices = [];

                            if(Yii::$app->request->post('Choice'))
                            {
                                foreach(Yii::$app->request->post('Choice') as $key=>$val)
                                {
                                    $choices[$key] = new Choice;
                                }
                            }

                            MultipleModel::loadMultiple($choices, Yii::$app->request->post());

                        // validate all models
                            $modelValidation = $model->validate();
                            $valid = MultipleModel::validateMultiple($choices) && $modelValidation;
                            if ($valid) {    

                                try {
                                        $transaction = \Yii::$app->db->beginTransaction();

                                        $model->save();

                                        if ($flag = $model->save(false)) 
                                        {
                                            foreach($choices as $choice) 
                                            {
                                                if($choice->value != ""){
                                                    $choice->indicator_id = $model->id;
                                                    if (! ($flag = $choice->save(false))) 
                                                    {
                                                        $transaction->rollBack();
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                        if($flag)
                                        {

                                            $transaction->commit();
                                            return $this->redirect(['view', 'id' => $model->id]);
                                        }
                                        return $this->redirect(['create']);
                                } catch (Exception $e) {
                                    $transaction->rollBack();
                                } 
                            }
                            else{      

                                // echo "<pre>";              
                                // print_r();exit;
                            }
                        } // else end_1
                    // } // else after throw forbidden
                }
                else // else if not exist the file attachment in indicator
                {

                        if(Indicator::find()->where(['category_id' => $model->category_id, 'unit_id' => 10])->exists())
                        {
                            // if($model->unit_id == 10)
                            // {
                            //     throw new \yii\web\HttpException(403, 'The category has already a file attachment widget.');
                            // }
                            // else
                            // {
                                $model->type_id = 4;
                                $model->unit_id = 10;
                                $model->default_choice_id = NULL;
                                $model->save();
                                return $this->redirect(['view', 'id' => $model->id]);
                            // }
                            
                        }
                        else
                        {
                            //////////////////////////////////------------------------------------
                            if($model->default_choice_id != 1)
                            {
                                if($model->type_id == 4)
                                {
                                    $model->unit_id = null;
                                    $model->save();
                                    return $this->redirect(['view', 'id' => $model->id]);
                                }
                                else
                                {
                                    /////////////////////////////////-----------dynamic-form-1
                                    if($model->temp_content_type_id == 9 || $model->temp_content_type_id == 10)
                                    {// else start_1 
                                    
                                        $model->type_id = 2;
                                        $model->unit_id = 7;
                                        $model->default_choice_id = 1;
                                    }
                                    else if($model->temp_content_type_id == 8)
                                    {
                                        $model->type_id = 2;
                                        $model->unit_id = 8;
                                    }
                                        $ans = $model->answer_with_question;

                                        $choices = [];

                                        if(Yii::$app->request->post('Choice'))
                                        {
                                            foreach(Yii::$app->request->post('Choice') as $key=>$val)
                                            {
                                                $choices[$key] = new Choice;
                                            }
                                        }

                                        MultipleModel::loadMultiple($choices, Yii::$app->request->post());

                                    // validate all models
                                        $modelValidation = $model->validate();
                                        $valid = MultipleModel::validateMultiple($choices) && $modelValidation;
                                        if ($valid) {    

                                            try {
                                                    $transaction = \Yii::$app->db->beginTransaction();


                                                    $model->save();

                                                    if ($flag = $model->save(false)) 
                                                    {
                                                        foreach($choices as $choice) 
                                                        {
                                                            if($choice->value != ""){
                                                                $choice->indicator_id = $model->id;
                                                                if (! ($flag = $choice->save(false))) 
                                                                {
                                                                    $transaction->rollBack();
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if($flag)
                                                    {

                                                        $transaction->commit();
                                                        return $this->redirect(['view', 'id' => $model->id]);
                                                    }
                                                    return $this->redirect(['create']);
                                            } catch (Exception $e) {
                                                $transaction->rollBack();
                                            } 
                                        }
                                        else{      

                                            // echo "<pre>";              
                                            // print_r();exit;
                                        }
                                   
                                    ////////////////////////////////------------dynamic-form1
                                }
                                
                            }
                            
                            else 
                            {
                                ////////////////////////////------------------ dynamic-form
                                    $ans = $model->answer_with_question;

                                    $choices = [];

                                    if(Yii::$app->request->post('Choice'))
                                    {
                                        foreach(Yii::$app->request->post('Choice') as $key=>$val)
                                        {
                                            $choices[$key] = new Choice;
                                        }
                                    }

                                    MultipleModel::loadMultiple($choices, Yii::$app->request->post());

                                // validate all models
                                    $modelValidation = $model->validate();
                                    $valid = MultipleModel::validateMultiple($choices) && $modelValidation;
                                    if ($valid) {    

                                        try {
                                                $transaction = \Yii::$app->db->beginTransaction();


                                                $model->save();

                                                if ($flag = $model->save(false)) 
                                                {
                                                    foreach($choices as $choice) 
                                                    {
                                                        if($choice->value != ""){
                                                            $choice->indicator_id = $model->id;
                                                            if (! ($flag = $choice->save(false))) 
                                                            {
                                                                $transaction->rollBack();
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }

                                                if($flag)
                                                {

                                                    $transaction->commit();
                                                    return $this->redirect(['view', 'id' => $model->id]);
                                                }
                                                return $this->redirect(['create']);
                                        } catch (Exception $e) {
                                            $transaction->rollBack();
                                        } 
                                    }
                                    else{      

                                        // echo "<pre>";              
                                        // print_r();exit;
                                    }
                                ///////////////////////////-------------------- dynamic-form
                            }
                            /////////////////////////////////-------------------------------------
                            
                        }
                    
                }

            
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                'types' => $types,
                'units' => $units,
                'frequencies' => $frequencies,
                'dchoices' => $dchoices,
                'choices' => $choices,
                'in_chart' => $in_chart,
            ]);
        }
    }

    /**
     * Updates an existing Indicator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $choices = $model->manyChoices;

        $categories = Category::find()->all();
        $categories = ArrayHelper::map($categories,'id','title');
        $types = Type::find()->all();
        $types = ArrayHelper::map($types,'id','title');
        $units = Unit::find()->where(['<>', 'id', 1])->all();
        $units = ArrayHelper::map($units,'id','title');
        $frequencies = Frequency::find()->all();
        $frequencies = ArrayHelper::map($frequencies,'id','title');
        $dchoices = DefaultChoice::find()->orderBy(['id' => SORT_DESC])->all();
        $dchoices = ArrayHelper::map($dchoices,'id','title');
        $in_chart = [0 => "No", 1 => "Yes"];

        if ($model->load(Yii::$app->request->post())) {

            if($model->type_id == 1 || $model->type_id == 3 || $model->type_id == 4)
            {
                $model->unit_id = null;
            }
            
                // start-after post
            $oldIDs = ArrayHelper::map($choices, 'id', 'id');
               
            $choices = [];

            if(Indicator::find()->where(['category_id' => $model->category_id, 'type_id' => 4])->exists() && $model->unit_id != 10)
            {
                // if($model->type_id == 4)
                // {
                //     throw new \yii\web\HttpException(403, 'The category has already a file attachment widget.');
                // }
                // else
                // {

                    if($model->default_choice_id != 1)
                    {

                        $model->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    else 
                    { // else start-4
                        if($model->temp_content_type_id == 9 || $model->temp_content_type_id == 10)
                        {// else start_1 
                        
                            $model->type_id = 2;
                            $model->unit_id = 7;
                            $model->default_choice_id = 1;
                        }
                        else if($model->temp_content_type_id == 8)
                        {
                            $model->type_id = 2;
                            $model->unit_id = 8;
                        }
                        
                        if(Yii::$app->request->post('Choice'))
                        {

                            foreach(Yii::$app->request->post('Choice') as $key=>$val)
                            {
                                $choices[$key] = new Choice;
                                $choices[$key]['id'] = isset(Yii::$app->request->post('Choice')[$key]['id']) ? Yii::$app->request->post('Choice')[$key]['id'] : '';
                                $choices[$key]['indicator_id'] = $model->id;
                                $choices[$key]['value'] = Yii::$app->request->post('Choice')[$key]['value'];
                            }
                        }

                        MultipleModel::loadMultiple($choices, Yii::$app->request->post());
                        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($choices, 'id', 'id')));
                        $transaction = \Yii::$app->db->beginTransaction();

                        try {
                                if ($flag = $model->save(false)) 
                                {
                                    if (!empty($deletedIDs)) 
                                    {
                                    Choice::deleteAll(['id' => $deletedIDs]);
                                    }
                                    foreach($choices as $choice) 
                                    {
                                        if(in_array($choice['id'], $oldIDs))
                                        {
                                            $choiceModel = Choice::find()->where(['id' => $choice['id']])->one();
                                            if($choiceModel)
                                            {
                                                $choiceModel->indicator_id = $choice['indicator_id'];
                                                $choiceModel->default_choice_id = $choice['default_choice_id'];
                                                $choiceModel->value = $choice['value'];
                                                if (! ($flag = $choiceModel->save(false))) {
                                                    $transaction->rollBack();
                                                    break;
                                                }
                                            }
                                        }else{
                                            $choice->indicator_id = $model->id;
                                            $choice->default_choice_id = NULL;
                                            $choice->value = $choice['value'];
                                            if (! ($flag = $choice->save(false))) {
                                                $transaction->rollBack();
                                                break;
                                            }
                                        }  
                                    }
                                    $transaction->commit();
                                    return $this->redirect(['view', 'id' => $model->id]);

                                }
                                   
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                    } // else end-4
                //} // else after throw forbidden
            }
            else
            {
               
				if(Indicator::find()->where(['category_id' => $model->category_id, 'unit_id' => 10])->exists())
				{
					// if($model->unit_id == 10)
					// {
					// 	throw new \yii\web\HttpException(403, 'The category has already a file attachment widget.');
					// }
					// else
					// {

						$model->type_id = 4;
						$model->unit_id = 10;
						$model->default_choice_id = NULL;
						$model->save();
						return $this->redirect(['view', 'id' => $model->id]);
					// }
					
				}
				else
				{
					if($model->temp_content_type_id == 9 || $model->temp_content_type_id == 10)
                    {// else start_1 
                    
                        $model->type_id = 2;
                        $model->unit_id = 7;
                        $model->default_choice_id = 1;
                    }
                    else if($model->temp_content_type_id == 8)
                    {
                        $model->type_id = 2;
                        $model->unit_id = 8;
                    }
					//////////////////////////////////////////////-----------------------------------------
					if($model->default_choice_id != 1)
					{
						if($model->type_id == 4)
						{
							$model->unit_id = 10;
							$model->type_id = 4;
							$model->save();
							return $this->redirect(['view', 'id' => $model->id]);
						}
						else
						{
							////////////////////////////////----------- dynamic-form-update
							if(Yii::$app->request->post('Choice'))
							{

								foreach(Yii::$app->request->post('Choice') as $key=>$val)
								{
									$choices[$key] = new Choice;
									$choices[$key]['id'] = isset(Yii::$app->request->post('Choice')[$key]['id']) ? Yii::$app->request->post('Choice')[$key]['id'] : '';
									$choices[$key]['indicator_id'] = $model->id;
									$choices[$key]['value'] = Yii::$app->request->post('Choice')[$key]['value'];
								}
							}

							MultipleModel::loadMultiple($choices, Yii::$app->request->post());
							$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($choices, 'id', 'id')));
							$transaction = \Yii::$app->db->beginTransaction();

							try {
									if ($flag = $model->save(false)) 
									{
										if (!empty($deletedIDs)) 
										{
										Choice::deleteAll(['id' => $deletedIDs]);
										}
										foreach($choices as $choice) 
										{
											if(in_array($choice['id'], $oldIDs))
											{
												$choiceModel = Choice::find()->where(['id' => $choice['id']])->one();
												if($choiceModel)
												{
													$choiceModel->indicator_id = $choice['indicator_id'];
													$choiceModel->default_choice_id = $choice['default_choice_id'];
													$choiceModel->value = $choice['value'];
													if (! ($flag = $choiceModel->save(false))) {
														$transaction->rollBack();
														break;
													}
												}
											}else{
												$choice->indicator_id = $model->id;
												$choice->default_choice_id = NULL;
												$choice->value = $choice['value'];
												if (! ($flag = $choice->save(false))) {
													$transaction->rollBack();
													break;
												}
											}  
										}
										$transaction->commit();
										return $this->redirect(['view', 'id' => $model->id]);

									}
									   
								} catch (Exception $e) {
									$transaction->rollBack();
								}
							///////////////////////////////------------ dynamic-form-update
						}
					}
					else 
					{ // else start-4
						if($model->temp_content_type_id == 9 || $model->temp_content_type_id == 10)
                        {// else start_1 
                        
                            $model->type_id = 2;
                            $model->unit_id = 7;
                            $model->default_choice_id = 1;
                        }
                        else if($model->temp_content_type_id == 8)
                        {
                            $model->type_id = 2;
                            $model->unit_id = 8;
                        }
                        
						if(Yii::$app->request->post('Choice'))
						{

							foreach(Yii::$app->request->post('Choice') as $key=>$val)
							{
								$choices[$key] = new Choice;
								$choices[$key]['id'] = isset(Yii::$app->request->post('Choice')[$key]['id']) ? Yii::$app->request->post('Choice')[$key]['id'] : '';
								$choices[$key]['indicator_id'] = $model->id;
								$choices[$key]['value'] = Yii::$app->request->post('Choice')[$key]['value'];
							}
						}

						MultipleModel::loadMultiple($choices, Yii::$app->request->post());
						$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($choices, 'id', 'id')));
						$transaction = \Yii::$app->db->beginTransaction();

						try {
								if ($flag = $model->save(false)) 
								{
									if (!empty($deletedIDs)) 
									{
									Choice::deleteAll(['id' => $deletedIDs]);
									}
									foreach($choices as $choice) 
									{
										if(in_array($choice['id'], $oldIDs))
										{
											$choiceModel = Choice::find()->where(['id' => $choice['id']])->one();
											if($choiceModel)
											{
												$choiceModel->indicator_id = $choice['indicator_id'];
												$choiceModel->default_choice_id = $choice['default_choice_id'];
												$choiceModel->value = $choice['value'];
												if (! ($flag = $choiceModel->save(false))) {
													$transaction->rollBack();
													break;
												}
											}
										}else{
											$choice->indicator_id = $model->id;
											$choice->default_choice_id = NULL;
											$choice->value = $choice['value'];
											if (! ($flag = $choice->save(false))) {
												$transaction->rollBack();
												break;
											}
										}  
									}
									$transaction->commit();
									return $this->redirect(['view', 'id' => $model->id]);

								}
								   
							} catch (Exception $e) {
								$transaction->rollBack();
							}
					} // else end-4
					/////////////////////////////////////////////------------------------------------------
				}

                //////////////    
            
            }
             
        }else
        {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'types' => $types,
                'units' => $units,
                'frequencies' => $frequencies,
                'dchoices' => $dchoices,
                'choices' => (empty($choices)) ? [new Choice] : $choices,
                'in_chart' => $in_chart,
            ]);
        }

    }


    /**
     * Updates an existing Sub-questions.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateSubquestion($id)
    {
        $model = $this->findModel($id);
        $subquestions = $model->subQuestions;
        $cs = ChoiceWithSubQuestion::find()->where(['indicator_id' => $model->id])->One();


        $units = Unit::find()->where(['and',
           ['<>','id', 1],
           ['<>','id', 7]
       ])->all();
        $units = ArrayHelper::map($units,'id','title');

        $chs = $model->choices;
        $chs = ArrayHelper::map($chs,'value','value');

        if ($cs->load(Yii::$app->request->post())) {
        
            $oldIDs = ArrayHelper::map($subquestions, 'id', 'id');
               
                $subquestions = [];

                if(Yii::$app->request->post('SubQuestion')){

                    foreach(Yii::$app->request->post('SubQuestion') as $key=>$val){
                        $subquestions[$key] = new SubQuestion;
                        $subquestions[$key]['id'] = isset(Yii::$app->request->post('SubQuestion')[$key]['id']) ? Yii::$app->request->post('SubQuestion')[$key]['id'] : '';
                        $subquestions[$key]['indicator_id'] = $model->id;
                        $subquestions[$key]['sub_question'] = Yii::$app->request->post('SubQuestion')[$key]['sub_question'];
                        $subquestions[$key]['type'] = Yii::$app->request->post('SubQuestion')[$key]['type'];
                    }
                }

                MultipleModel::loadMultiple($subquestions, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($subquestions, 'id', 'id')));

                $transaction = \Yii::$app->db->beginTransaction();

                    try {
                            if ($flag = $cs->save(false)) 
                            {
                                if (!empty($deletedIDs)) {
                                SubQuestion::deleteAll(['id' => $deletedIDs]);
                                }
                                foreach($subquestions as $subquestion) 
                                {
                                    if(in_array($subquestion['id'], $oldIDs))
                                    {
                                        $subquestionModel = SubQuestion::find()->where(['id' => $subquestion['id']])->one();
                                        if($subquestionModel){
                                            $subquestionModel->indicator_id = $subquestion['indicator_id'];
                                            $subquestionModel->sub_question = $subquestion['sub_question'];
                                            $subquestionModel->type = $subquestion['type'];
                                            if (! ($flag = $subquestionModel->save(false))) {
                                                $transaction->rollBack();
                                                break;
                                            }
                                        }
                                    }else{
                                        $subquestion->indicator_id = $model->id;
                                        $subquestion->sub_question = $subquestion['sub_question'];
                                        $subquestion->type = $subquestion['type'];
                                        if (! ($flag = $subquestion->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }  
                                }
                            }
                            if ($flag) 
                            {
                                $transaction->commit();
                            }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update-subquestion', [
                'model' => $model,
                'subquestions' => $subquestions,
                'units' => $units,
                'cs' => $cs,'chs' => $chs,
            ]);
        }
    }




    /**
     * Deletes an existing Indicator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Indicator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Indicator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Indicator::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
