<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use backend\models\search\ProductSearch;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AdminController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

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
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }/**/
    
    
    protected function addImage($model){
    	if ($file = UploadedFile::getInstance($model,'imageFile') ){
    		$filePath = Yii::getAlias ( '@frontend' ) . '/web/images/products/'.$model->alias.'/';
    		if (!is_dir($filePath)){
    			mkdir($filePath);
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
    
    public function actionUpdateMetaData(){
    	
    	$behavior =   $behavior = new \backend\behaviors\metaData\MetaDataBehavior;
    //	 var_dump($model->load(Yii::$app->request->post()));
    	$behavior->autoPageTitle = Yii::$app->request->post('Product')['autoPageTitle'];
    	$behavior->pageTitleTemplate = Yii::$app->request->post('Product')['pageTitleTemplate'];
    	$behavior->randomPTT = Yii::$app->request->post('Product')['randomPTT'];
    	$behavior->randomPTTData = Yii::$app->request->post('Product')['randomPTTData'];
    	
    	$behavior->autoMeta_d = Yii::$app->request->post('Product')['autoMeta_d'];
    	$behavior->meta_dTemplate = Yii::$app->request->post('Product')['meta_dTemplate'];
    	$behavior->randomMDT = Yii::$app->request->post('Product')['randomMDT'];
    	$behavior->randomMDTData = Yii::$app->request->post('Product')['randomMDTData'];
    	
    	$behavior->autoMeta_k = Yii::$app->request->post('Product')['autoMeta_k'];
    	$behavior->meta_kTemplate = Yii::$app->request->post('Product')['meta_kTemplate'];
    	$behavior->randomMKT = Yii::$app->request->post('Product')['randomMKT'];
    	$behavior->randomMKTData = Yii::$app->request->post('Product')['randomMKTData'];
   //   var_dump($behavior);//die;
     //    $product = Yii::$app->request->post('Product');
            $category_id = $product['category_id'];
            $manufacturer_id = $product['manufacturer_id'];
            unset($_POST['Product']['category_id']);
              unset($_POST['Product']['manufacturer_id']);
              
                        $query = Product::find()->select('id,title,pageTitle,meta_d,meta_k,category_id,brand_id');
                        if($category_id){
                            $query->addFilterWhere('=','category_id',':category_id');
                            $query->addParams([':category_id'=>$category_id]);
                        }
                             if($manufacturer_id){
                            $query->addFilterWhere('=','brand_id',':brand_id');
                              $query->addParams([':brand_id'=>$manufacturer_id]);
                        }
                        $products = $query->all();
                  //      $model->validate();
                      //    var_dump( $products);die;
           $count = 0;
           $errors = array();
       
            if (count($products)>0)
            foreach ($products as $product){
      	$product->attachBehavior('metaData', $behavior);
       //      var_dump($behavior);die;
              //  $product->scenario = 'updateMetaData';
            if ($product->save()){
                  
                $count++;
            } else{
          	$errors[$product->id] = $product->getErrors();
            }
            }
            if (count($errors)>0 ){
            	$string = '';
            
            	// Перебираем ошибки бдля вывода
            	 
            	 
            	foreach($errors as $id => $error){
            		$string .= '<span style="color:red;">ID - '.$id.'</span>;';
            		foreach ($error as $key => $value){
            			$string .=  '<span style="color:red;">'.$value[0].'</span>;<br/>';
            		}
            		 
            	}
            	Yii::$app->session->setFlash('warning','Meta Данные '.$count.' Товаров успешно обновлены.<br/>
                                  При обновлении  произошли ошибки: <br/>  '.$string);
            
            } else{
            Yii::$app->session->setFlash('success', 'Meta Данные '.$count.' Товаров успешно обновлены.');
	
            }
            $this->redirect(['index']);
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
    				
    					$product = new \common\models\Product();
    					
    					unset ( $xls [1] );
    					$labels = $product->attributeLabels ();
    					$labels = array_flip ( $labels );
    					foreach ( $columns as $key => $col ) {
    						$columns [$key] = $labels [$col];
    					} // end foreach
    				}
    					
    				// $data = $obj-> readActiveSheet($filePath. $file->baseName . '.' . $file->extension);
    				return $this->render ( 'import_xls', [
    						'xls' => $xls,
    						'columns' => $columns,
    						'importModel' => 'Product',
    						'labels'=>$product->attributeLabels (),
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
    		unset ( $data ['supplyModel'] );
    		foreach ( $data as $row ) {
    
    		
    			$model = \common\models\Product::find ()->where (['id' => $row ['Product']['id']] )->one ();
    			if (! $model) {
    				$model = new \common\models\Product();
    			}
    		if($row['Product']['discount'] ==='(не задано)') $row['Product']['discount'] = null;
    		if($row['Product']['views'] ==='(не задано)') $row['Product']['views'] = null;
    		if($row['Product']['category']==='(не задано)') {
    			$row['Product']['category_id'] = null;
    		}else {
    			$row['Product']['category_id'] = \common\models\Category::find()->select('id')
    			->where(['title'=>$row['Product']['category']])->one()->id;
    		}
    		unset($row['Product']['category']);
    		if($row['Product']['brand']==='(не задано)') {
    			$row['Product']['brand_id'] = null;
    		}else {
    			$row['Product']['brand_id'] = \common\models\Brand::find()->select('id')
    			->where(['title'=>$row['Product']['brand']])->one()->id;
    		}
    		unset($row['Product']['brand']);
    				//var_dump($model->load ( $row ));
    		//var_dump($row);
    			if ($model->load($row)){
    			//	var_dump($model);
    				if (! $model->save ()) {
    					$errors [$model ['id']] = $model->getErrors ();
    				}else
    				{
    					$count ++;
    				}
    				//	var_dump($model);
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
    
}/**/
