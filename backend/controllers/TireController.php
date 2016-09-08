<?php

namespace backend\controllers;

use yii;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use common\models\tires\Tire;
use backend\models\search\tires\TireSearch;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * TireController implements the CRUD actions for Tire model.
 */
class TireController extends AdminController
{
    private $items;
 public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Tire models.
     * @return mixed
     */
    public function actionIndex()
    {
      
        $searchModel = new TireSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
         
                
                        
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tireModels' =>$this->getTireModels()
        ]);
    }

    /**
     * Displays a single Tire model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
         }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Tire model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tire();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tire model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         
            return $this->redirect(['tire/view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tire model.
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
     * Finds the Tire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tire::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }/**/
    
    public function actionImport(){
    	$model = new \backend\models\ImportForm;
    	if (Yii::$app->request->post ( 'csvinit' )) {
    		$model->load ( Yii::$app->request->post () );
    		$model->file = UploadedFile::getInstances ( $model, 'file' );
    		// var_dump( $model->file);die;
    		/*
    		 * var_dump($model->validate());
    		 * var_dump($model->getErrors());
    		 * die;
    		*/
    		if ($model->file && $model->validate ()) {
    			foreach ( $model->file as $file ) {
    				$filePath = Yii::getAlias ( '@root' ) . '/uploads/';
    				$file->saveAs ( $filePath . $file->baseName . '.' . $file->extension );
    				$obj = new \PHPExcel ();
    				//	var_dump($obj);die;
    				$reader = \PHPExcel_IOFactory::load ( $filePath . $file->baseName . '.' . $file->extension );
    				$xls = $reader->getActiveSheet ()->toArray ( null, true, true, true );
    
    				foreach ($xls[1] as $key =>$value)
    					$xls[1][$key] = trim($value);
    
    				 
    				 
    				if (in_array ( 'ID', $xls [1] )) {
    					// var_dump($xls[1]);
    					$columns = $xls [1];
    
    					$tire = new \common\models\tires\Tire();
    						
    					unset ( $xls [1] );
    					$labels = $tire->attributeLabels ();
    					$labels = array_flip ( $labels );
    					foreach ( $columns as $key => $col ) {
    						$columns [$key] = $labels [$col];
    					} // end foreach
    				}
    					
    				// $data = $obj-> readActiveSheet($filePath. $file->baseName . '.' . $file->extension);
    				return $this->render ( '/product/import_xls', [
    						'xls' => $xls,
    						'columns' => $columns,
    							'importModel' => 'Tire',
    						'labels'=>$tire->attributeLabels (),
    				] );
    			}
    		}
    	} elseif (Yii::$app->request->post ( 'csvgo' )) {
    		$errors = [ ];
    		$count = 0;
    		$data = Yii::$app->request->post ();
    
    		//	var_dump(new $supplierModel());die;
    		 
    		unset ( $data ['csvgo'] );
    		unset ( $data ['_csrf'] );
    		
    		foreach ( $data as $row ) {
    			
    
    			$model = \common\models\tires\Tire::find ()->where (['id' => $row['Tire']['id']] )->one ();
    		
    			if (! $model) {
    				$model = new \common\models\tires\Tire();
    			}
    		
    			if($row['Tire']['ship'] ==='(не задано)') $row['Tire']['ship'] = null;
    			if($row['Tire']['usilennaya'] ==='(не задано)') $row['Tire']['usilennaya'] = null;
    			if($row['Tire']['price'] ==='(не задано)') $row['Tire']['price'] = null;
    			if($row['Tire']['discount'] ==='(не задано)') $row['Tire']['discount'] = null;
    			if($row['Tire']['views'] ==='(не задано)') $row['Tire']['views'] = null;
    			if($row['Tire']['quantity'] ==='(не задано)') $row['Tire']['quantity'] = null;

    		
    			
    			if ($model->load($row)){
    					
    				if (! $model->save ()) {
    					$errors [$model ['id']] = $model->getErrors ();
    				}else
    				{
    				//	var_dump($model);
    					$count ++;
    				}
    		//			
    				//	die;
    			} // end if load
    			$model = "";
    			 
    		} // endforeach;
    		//var_dump($errors);
    		//	die;
    		if (count ( $erorrs ) == 0) {
    			Yii::$app->session->setFlash ( 'success', 'Импортирование прошло успешно.
        				Импортировано ' . $count . ' позиций' );
    		} else {
    			Yii::$app->session->setFlash ( 'warning', 'При импортировании возникло ' . count ( $erorrs ) . ' ошибок.
        				Импортировано ' . $count . ' позиций' );
    		}
    		
    		return $this->redirect ( ['index'] );
    	}// end csv go
    }/**/
    
    public function actionExport(){
        $format = Yii::$app->request->post('format');
        $platform = Yii::$app->request->post('platform');
        $this->items = Yii::$app->request->post('positions');
        $currencies = Yii::$app->request->post('curriencies');
     //   var_dump( $this->items);die;
        if (strpos($platform,'.')){
            $plat = explode('.', $platform);
            $platform = $plat[0];
        }
    
        $duration = 60*60*24*7;// one week
         // TiresModels
        $dependency = new \yii\caching\DbDependency([
        		'sql' => 'SELECT MAX(updated) FROM'.\common\models\tires\Tire::tableName(),
        ]);
        $categories =  \common\models\tires\TireCarType::find()->all();
        $data = \common\models\tires\Tire::getDb()->cache(function ($db) {
       //     var_dump($this->items);
            return \common\models\tires\Tire::find()
                    ->where(['in','id',$this->items])->all();
        },$duration,$dependency);
     //   var_dump($data);die;
        switch ($format){
            case 'xml':
   
                switch ($platform){
                case 'rozetka':
                     Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
   $headers = Yii::$app->response->headers;
   $headers->add('Content-Type', 'text/xml; charset=utf-8');
  
                return $this->renderPartial('export'.ucfirst($format).ucfirst($platform),[
        		'host'=>Yii::$app->request->hostInfo,
        		'items'=>$data,
        		'categories'=>$categories,
                        'currencies' =>$currencies,
        		]);     
                    break;
                }
      
 
                
                break;
        }
       
      
    }/**/
    
    private function getTireModels(){
        $brand_id = NULL;
      if (isset(Yii::$app->request->get('TireSearch')['brandTitle'])){
        $brand_id = Yii::$app->request->get('TireSearch')['brandTitle'];
      }
         $query = \common\models\tires\TireModel::find();
                $query->select(['id','title']);
                if ($brand_id !== null && $brand_id>0){
                    $query->where('brand_id = :id',
                            [':id'=>$brand_id]);
                }
                 $query ->orderBy(['title'=>'ACS']);
                $query->asArray();
                $models= $query->all();
          //  $tireModels[]=Yii::t('app','Models');
            $tireModels = \yii\helpers\ArrayHelper::map($models, 'id', 'title');
           
            return $tireModels;
    }/**/
    
}/*end of Controller*/
