<?php

namespace backend\controllers;

use Yii;
use common\models\disks\DiskModel;
use backend\models\search\disks\DiskModelSearch;
use yii\web\Controller;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiskModelController implements the CRUD actions for DiskModel model.
 */
class DiskModelController extends AdminController
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
     * Lists all DiskModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiskModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data = [];
        $emptyImages= DiskModel::find()->where('image IS Null')->count();
        $emptyDescs= DiskModel::find()->where('long_desc IS Null')->count();
        $emptyMeta= DiskModel::find()->where('(pageTitle IS Null) OR (meta_k IS Null) OR (meta_d IS Null) ')->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           
            'emptyImages'=>$emptyImages,
            'emptyDescs'=>$emptyDescs,
            'emptyMeta'=>$emptyMeta
        ]);
    }

    /**
     * Displays a single DiskModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       $model = $this->findModel($id);
        $searchModelDisk = new \backend\models\search\disks\DiskSearch;
        $dataProviderDisk = $searchModelDisk->search(Yii::$app->request->queryParams,$model->id);
      
        return $this->render('view', [
            'model' => $model,
            'searchModelDisk' => $searchModelDisk,
            'dataProviderDisk' => $dataProviderDisk,
        ]);
    }

    /**
     * Creates a new DiskModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DiskModel();

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
     * Updates an existing DiskModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing DiskModel model.
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
     * Finds the DiskModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DiskModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiskModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }/**/
    
     public function actionUpdateMetaData(){
    	$behavior =   $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
    	
    	$behavior->randomPTTData =Yii::$app->request->post('DiskModel')['randomPTTData'];
    	$behavior->randomPTT = Yii::$app->request->post('DiskModel')['randomPTT'];
    	$behavior->autoPageTitle = Yii::$app->request->post('DiskModel')['autoPageTitle'];
    	
    	$behavior->randomMDTData =Yii::$app->request->post('DiskModel')['randomMDTData'];
    	$behavior->randomMDT = Yii::$app->request->post('DiskModel')['randomMDT'];
    	$behavior->autoMeta_d = Yii::$app->request->post('DiskModel')['autoMeta_d'];
    	
    	$behavior->randomMKTData =Yii::$app->request->post('DiskModel')['randomMKTData'];
    	$behavior->randomMKT = Yii::$app->request->post('DiskModel')['randomMKT'];
    	$behavior->autoMeta_k = Yii::$app->request->post('DiskModel')['autoMeta_k'];
        	
    	$diskModels = \common\models\disks\DiskModel::find()
    	->select('id,brand_id,pageTitle,meta_d,meta_k,title,alias,category_id')->all();
    	$count = 0;
    	$errors = [];
    	foreach ($diskModels as $diskModel){
    		$diskModel->attachBehavior('metaData', $behavior);
    	//	var_dump($tireModel->randomPTTData);die;
    	if(! $diskModel->save()){
    		
    	$erorrs[$diskModel->id]	= $diskModel->getErrors();
    	
    	}else{
    	//	var_dump($tireModel->pageTitle);
    	//	var_dump($tireModel->meta_k);
    	//	var_dump($tireModel->meta_d);
    	$count++;
    	}//end if
    	//var_dump($tireModel);
    //	die;
    	}// end foreach
    //	$tireModel = new \common\models\tires\DiskModel();
    	return $this->redirect(['index']);
    }/**/
    
     private function addImage($model){
    	if ($file = UploadedFile::getInstance($model,'imageFile') ){
    		$filePath = Yii::getAlias ( '@frontend' ) . '/web/images/disks/'.$model->brand->alias.'/';
                        
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
    
    
}/**/
