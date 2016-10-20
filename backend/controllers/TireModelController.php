<?php

namespace backend\controllers;

use Yii;
use common\models\tires\TireModel;
use backend\models\search\tires\TireModelSearch;
use common\models\tires\Tire;
use backend\models\search\tires\TireSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * TireModelController implements the CRUD actions for TireModel model.
 */
class TireModelController extends \backend\components\AdminController
{
   public $enableCsrfValidation = FALSE;
    
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
     * Lists all TireModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TireModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data = [];
        $emptyImages= TireModel::find()->where('image IS Null')->count();
        $emptyDescs= TireModel::find()->where('long_desc IS Null')->count();
        $emptyMeta= TireModel::find()->where('(pageTitle IS Null) OR (meta_k IS Null) OR (meta_d IS Null) ')->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tireModels' =>$this->getTireModels(Yii::$app->request->get('TireModelSearch')['brand_id']),
           
            'emptyImages'=>$emptyImages,
            'emptyDescs'=>$emptyDescs,
            'emptyMeta'=>$emptyMeta
        ]);
    }

    /**
     * Displays a single TireModel model.
     * @param integer $id
     * @param string $url
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModelTire = new TireSearch;
        $dataProviderTire = $searchModelTire->search(Yii::$app->request->queryParams,$model->id);
      
        return $this->render('view', [
            'model' => $model,
            'searchModelTire' => $searchModelTire,
            'dataProviderTire' => $dataProviderTire,
        ]);
    }

    /**
     * Creates a new TireModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TireModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$this->addImage($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TireModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $url
     * @return mixed
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
    	$this->addImage($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TireModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $url
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }/**/
    
    public function actionUpdateMetaData(){
    	$behavior =   $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
    	
    	$behavior->randomPTTData =Yii::$app->request->post('TireModel')['randomPTTData'];
    	$behavior->randomPTT = Yii::$app->request->post('TireModel')['randomPTT'];
    	$behavior->autoPageTitle = Yii::$app->request->post('TireModel')['autoPageTitle'];
    	
    	$behavior->randomMDTData =Yii::$app->request->post('TireModel')['randomMDTData'];
    	$behavior->randomMDT = Yii::$app->request->post('TireModel')['randomMDT'];
    	$behavior->autoMeta_d = Yii::$app->request->post('TireModel')['autoMeta_d'];
    	
    	$behavior->randomMKTData =Yii::$app->request->post('TireModel')['randomMKTData'];
    	$behavior->randomMKT = Yii::$app->request->post('TireModel')['randomMKT'];
    	$behavior->autoMeta_k = Yii::$app->request->post('TireModel')['autoMeta_k'];
        	
    	$tireModels = \common\models\tires\TireModel::find()
    	->select('id,brand_id,pageTitle,meta_d,meta_k,title,alias,category_id')->all();
    	$count = 0;
    	$errors = [];
    	foreach ($tireModels as $tireModel){
    		$tireModel->attachBehavior('metaData', $behavior);
    	//	var_dump($tireModel->randomPTTData);die;
    	if(! $tireModel->save()){
    		
    	$erorrs[$tireModel->id]	= $tireModel->getErrors();
    	
    	}else{
    	//	var_dump($tireModel->pageTitle);
    	//	var_dump($tireModel->meta_k);
    	//	var_dump($tireModel->meta_d);
    	$count++;
    	}//end if
    	//var_dump($tireModel);
    //	die;
    	}// end foreach
    //	$tireModel = new \common\models\tires\TireModel();
    	return $this->redirect(['index']);
    }/**/
    

    /**
     * Finds the TireModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $url
     * @return TireModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TireModel::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::app('app','The requested page does not exist.'));
        }
    }/**/
    
    private function addImage($model){
    	if ($file = UploadedFile::getInstance($model,'imageFile') ){
    		$filePath = Yii::getAlias ( '@frontend' ) . '/web/images/tires/'.$model->brand->alias.'/';
                        
    		if (!is_dir($filePath)){
    			mkdir($filePath,0777);
    		}
                $filePath .= $model->alias.'/';
                
                if (!is_dir($filePath)){
    			mkdir($filePath,0777);
    		}
                
    		//	echo phpversion("imagick");die;
    		$imageFile = mb_strtolower($file->baseName) . '.' . $file->extension;
    		$file->saveAs ( $filePath . $imageFile );
    		$model->image = $imageFile;
    		$thumb = Image::thumbnail($filePath . $imageFile,120,120);
    		$thumbFile = mb_strtolower($file->baseName) . '_thumb.' . $file->extension;
    		$thumb->save($filePath . $thumbFile);
    		$model->thumbnail = $thumbFile;
    		$model->save();
    	
    	}
    }/**/
    
     private function getTireModels($brand_id = 0){
      
      if (isset(Yii::$app->request->get('TireModelSearch')['brandTitle'])){
        $brand_id = Yii::$app->request->get('TireModelSearch')['brandTitle'];
      }
         $query = \common\models\tires\TireModel::find();
                $query->select(['id','title']);
                if ($brand_id>0){
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
    
}/*end of Class*/
