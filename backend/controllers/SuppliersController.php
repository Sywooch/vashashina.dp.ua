<?php

namespace backend\controllers;

use Yii;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use backend\models\suppliers\TireTrader;
use backend\models\suppliers\search\TireTraderSearch as tts;
use common\models\tires\Tire;

class SuppliersController extends \backend\components\AdminController {
	public $supplier;
	private $supDir = 'backend\models\suppliers\\';
	private $supDirSearch = 'backend\models\suppliers\search\\';
        private $_event;
        
        const EVENT_AFTER_UPDATE_SUPPLIER_PRICE = 'afterUpdateSupplierPrice';
        const EVENT_AFTER_UPDATE_PRICE = 'afterUpdatePrice';

        public function init() {
        
            
            return parent::init();
        }/**/

        public function behaviors()
	{
		return array_merge(parent::behaviors(),[
				
		]);
	}/**/
	
	
	public function actionDeactivateSupplierPrice($supplier,$type) {
		$model = $this->supDir.$supplier.$type;
		$model::updateAll(['ostatok'=>0]);
		Yii::$app->session->setFlash ( 'warning', 'Прайс поставщика '.$supplier.$type.' обнулен! Обновите его!!!' );
					return $this->redirect ( [ 
					'/suppliers/view',
					'supplier' => $supplier,
                                        'type'=>$type,
			] );
	}/**/
	
	public function actionDeactivatePrice($supplier,$type, $all = FALSE){
		if ($all){
			switch($type){
				case 'Tires':
			Tire::updateAll(['quantity'=>0]);
			break;
				case "Disks":
                        \common\models\disks\Disk::updateAll(['quantity'=>0]);
					break;
					
				case 'Products':
					break;
			}
			Yii::$app->session->setFlash ( 'danger', 'Наш прайс шин обнулен полностью! Обновите его!!!' );
		} else{
			$supModel = $this->supDir.$supplier.$type;
			$errors = [];
			$count = 0;
                        switch($type){
				case 'Tires':
			$supPositions = $supModel::find()->select('tire_id')->where('tire_id > 0')->asArray()->all();
			if (count($supPositions)>0)
				foreach($supPositions as $sp){
				$tire = Tire::findOne($sp['tire_id']);
				if (isset ($tire->id)){
				$tire->quantity = 0;
			//	$tire->status = 0;
		//	var_dump($sp);
				if($tire->update() !== false){
					$count++;
				}else{
					$errors[$tire->id] = $tire->getErrors();
				}
				} // end if tire;
			}
			break;
				case "Disks":
                    	$supPositions = $supModel::find()->select('disk_id')->where('disk_id > 0')->asArray()->all();
			if (count($supPositions)>0)
				foreach($supPositions as $sp){
				$disk = \common\models\disks\Disk::findOne($sp['disk_id']);
				
				$disk->quantity = 0;
			//	$tire->status = 0;
		//	var_dump($sp);
				if($disk->update() !== false){
					$count++;
				}else{
					$errors[$disk->id] = $disk->getErrors();
				}
                                }
					break;
					
				case 'Products':
					break;
			}
			
			
		//	var_dump($supPositions);die;
			
			if (count($errors)>0){
				var_dump($errors);die;
			}else{
		
		Yii::$app->session->setFlash ( 'warning', 'Наш прайс для поставщика '.$supplier.' обнулен <br/> 
				(обнулено '.$count.' позиций)! Обновите его!!!' );
			}
			}
		return $this->redirect ( [
				'/suppliers/view',
				'supplier' => $supplier,
                                'type'=>$type,
		] );
		}/**/
	
	
	
	public function actionExport() {
		return $this->render ( 'export' );
	}
	public function actionImport() {
		// $obj = new \PHPExcel(); работает
		// var_dump($_FILES);die;
		$model = new UploadForm ();
		
		if (Yii::$app->request->post ( 'csvinit' )) {
			$model->load ( Yii::$app->request->post () );
			$model->file = UploadedFile::getInstances ( $model, 'file' );
//			 var_dump($model);die;
			/*
			 * var_dump($model->validate());
			 * var_dump($model->getErrors());
			 * die;
			 */
			if ($model->file && $model->validate ()) {
				foreach ( $model->file as $file ) {
					$filePath = Yii::getAlias ( '@backend' ) . '/web/tmp/';
					$file->saveAs ( $filePath . $file->baseName . '.' . $file->extension );
					$obj = new \PHPExcel ();
					$reader = \PHPExcel_IOFactory::load ( $filePath . $file->baseName . '.' . $file->extension );
					$xls = $reader->getActiveSheet ()->toArray ( null, true, true, true );
                    foreach ($xls[1] as $key =>$value){
						if ($value){
						$xls[1][$key] = trim($value);
						} else {unset($xls[1][$key]);}
					}
				//	var_dump($xls[1]);die;
					$supplier = $this->supDir . $model->supplier.$model->type;
					$supplier = new $supplier ();
                    $labels = $supplier->attributeLabels ();
                    unset($labels['status']);
                    unset($labels['created_at']);
                    unset($labels['updated_at']);
                    unset($labels['created_by']);
                    unset($labels['LastUpdatedBy']);
					if (in_array ( 'ID', $xls [1] )) {
					//	 var_dump($xls[1]);die;
						$columns = $xls [1];

						$labelsFlip = array_flip ( $labels );
                     //   var_dump($labels);die;
						foreach ( $xls [1] as $letter => $val ) {
							$columns [$letter] = \yii\helpers\Html::dropDownList('columns['.$letter.']',$labelsFlip[$val],$labels,
                                ['class'=>'form-control']);
						} // end foreach
                        unset($xls [1]);
					} else{
                     
                        foreach($xls[1] as $letter => $val){
                          $columns[$letter] = \yii\helpers\Html::dropDownList('columns['.$letter.']','',$labels,
                              ['class'=>'form-control']);
                        }

                    }
				//	 var_dump($columns);die;
                                        // var_dump($xls);die;
					// $data = $obj-> readActiveSheet($filePath. $file->baseName . '.' . $file->extension);
					return $this->render ( 'import_xls', [ 
							'xls' => $xls,
							'columns' => $columns,
							'supplyModel' => $model->supplier,
							'labels'=>$supplier->attributeLabels (),
                            'type'=>$model->type,
					] );
				}
			}
		} elseif (Yii::$app->request->post ( 'csvgo' )) {
			$errors = [ ];
			$countUpdated = 0;
			$countNew = 0;
			$count = 0;
			$data = Yii::$app->request->post ();
			$supplier = $data ['supplyModel'];
            $type = $data ['type'];
            $columns = $data['columns'];
			$supplierModel = $this->supDir . $supplier.$type;
			$db = Yii::$app->db;
			//var_dump($data);die;
			unset ( $data ['fileType'] );
			unset ( $data ['csvgo'] );
			unset ( $data ['_backendCSRF'] );
			unset ( $data ['supplyModel'] );
            unset ( $data['columns']);
            unset ( $data ['type'] );
		//	var_dump($columns,$data);die;
			foreach ( $data as $row ) {
				$count++;
                foreach ($row[$supplier.$type] as $letter => $col) {
                    $attributes[$columns[$letter]] = $col;
                    if ($columns[$letter] == 'data_obnovleniya_sklada') {
                        $attributes[$columns[$letter]] = strtotime($col);
                        //	$row['data_obnovleniya_sklada'] = date("Y-m-d H:i:s",$row['data_obnovleniya_sklada']);
                    }
                    //	var_dump($row);die;

                } // endforeach;
                    if (isset($attributes['id']) ) {
                        $id = $db->createCommand('SELECT id FROM ' . $supplierModel::tableName() . ' WHERE id = :id',
                            [':id' => $attributes['id']])->queryScalar();
                        //	var_dump($id);die;
                        $insert = FALSE;
                        $update = FALSE;
                        if ($id) {
                            unset($attributes['id']);
                            $update = $db->createCommand()
                                ->update($supplierModel::tableName(),$attributes, 'id = ' . $id)
                                ->execute();
                            //	var_dump($update);//die;
                        } else {
                            $insert = $db->createCommand()
                                ->insert($supplierModel::tableName(), $attributes)
                                ->execute();
                        }
                        if ($update) $countUpdated++;
                    }// if isset id
                    else {
                        $insert = $db->createCommand()
                            ->insert($supplierModel::tableName(), $attributes)
                            ->execute();
                    }
                    if ($insert) $countNew++;
                    //		var_dump($update);die;


			} // endforeach;
                       $message = '';
                       $status = '';
			//var_dump(count($errors));
			if (($countUpdated + $countNew) == $count) {
                            $status = 'success';
                            $message = 'Импортирование прошло успешно.'. 
        				'Импортировано ' . $count . ' позиций, в т.ч. обновлено '.$countUpdated.','
        						.' добавленно новых '.$countNew;
				Yii::$app->session->setFlash ( $status, $message );
			} else {
                              $status = 'warning';
                            $message = ' Импортировано ' . ($countUpdated + $countNew) 
                                    . ' позиций из '.$count.'. Возможно Вы просто ввели такие же данные!!!';
				Yii::$app->session->setFlash ( $status,$message);
			}
	
		 $this->_event = new \backend\events\UpdatePriceEvent();
                $this->_event->message = $message;
                $this->_event->status = $status;
                $this->_event->price = $type;
                $this->_event->supplier = $supplierModel;
             $this->on(self::EVENT_AFTER_UPDATE_SUPPLIER_PRICE, [$this->_event,self::EVENT_AFTER_UPDATE_SUPPLIER_PRICE]);
		 $this->trigger(self::EVENT_AFTER_UPDATE_SUPPLIER_PRICE, $this->_event);
			return $this->redirect ( [ 
					'/suppliers/view',
					'supplier' => $supplier,
                                        'type'=>$type,
			] );
		}
	
		return $this->render ( 'import', [ 
				'model' => $model 
		] );
	}/**/

	public function actionUpdatePrice($supplier,$type) {
            $message = NULL;
            $status = Null;
		$supModel = $this->supDir.$supplier.$type;
	//	$errors = [];
                     $select = 'vykhodnaya_roznichnaya_cena as price,ostatok as quantity';
                     $where = 'vykhodnaya_roznichnaya_cena > 0 AND ostatok > 0';
		$count = 0;
                switch ($type){
                    case "Tires":
                        $select .= ',tire_id';
                        $where .= ' AND tire_id > 0 ';
                        $model = '\common\models\tires\Tire';
                          $column = 'tire_id';; 
                        break;
                    case "Disks":
                        $select .= ',disk_id';
                        $where .= ' AND disk_id > 0';
                        $model = '\common\models\disks\Disk';
                          $column = 'disk_id';; 
                        break;
                    case "Product":
                        break;
                }
		$supPositions = $supModel::find()->select($select)
                        ->where($where)
                    
                        ->asArray()
                        ->all();
                $countSP = count($supPositions);
             //   var_dump($supPositions);
		if ($countSP>0){
			foreach($supPositions as $sp){
               //             var_dump($sp);
                    $id = $sp[$column];
                    unset($sp[$column]);
        $update = Yii::$app->db->createCommand()->update($model::tableName(), $sp, ['id'=>$id])->execute();
                    if ($update){
                        $count++;
                    }
		}
                if ($count > 0 ){
				Yii::$app->session->setFlash ( 'success', 'Наш прайс для поставщика '.$supplier.$type.' обновлен <br/>' 
				.'(обновлено '.$count.' позиций из '. $countSP .' возможных)! ' );
			}else{
		 Yii::$app->session->setFlash ( 'warning', 'Обновлено 0 позиций из '. $countSP .' возможных' );  
		
		//	echo "success";die;
			}
                } else {
                  Yii::$app->session->setFlash ( 'warning', 'Нет позиций для обновления' );  
                }
			
			
		return $this->redirect ( [
				'/suppliers/view',
				'supplier' => $supplier,
                                'type'=>$type
		] );
		
	
	}/**/
        
	public function actionView($supplier,$type) {
		$this->supplier = $supplier;
        //        var_dump($this->supplier);die;
		$supplier = $this->supDirSearch . $supplier . $type . 'Search';
		$searchModel = new $supplier (); // \backend\models\suppliers\search\TireTraderSearch();
		$supplierModel = $this->supDir.$this->supplier . $type ;
                switch ($type){
                    case "Tires":
                        $model = '\common\models\tires\Tire';
                        break;
                    
                    case "Disks":
                        $model = '\common\models\disks\Disk';
                        break;
                    case "Products":
                        $model = '\common\models\Product';
                        break;
                }
		//$supplierModel = $supplierModel::find()->count();
	//	var_dump($supplierModel);die;
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( 'index', [ 
				'searchModel' => $searchModel,
				'supplierModel' =>$supplierModel,
				'dataProvider' => $dataProvider,
                                'model'=>$model,
                                'type'=>$type,
		] );
	}/**/
public function actionUpdateOurPositions($supplier,$type,$update){
    $this->supplier = $supplier;
        
    $count = 0;
    $errors = [];
		
		
		$supplierModel = $this->supDir.$this->supplier . $type;
                // Определяем что мы будем обновлять
                switch ($type){
                    case "Tires":
                        $model = '\common\models\tires\Tire';
                        switch ($update){
                            case "brands":
                                $this->updateBrands($supplierModel, $type);
                         
                            break;
                        
                            case "models":
                           $this->updateModels($supplierModel,$type); 
                            break;
                            case "items":
                      $this->updateItems($supplierModel,$type);
                      
                                break;
                            case "prices":
                              $this->updatePrices($supplierModel,$type);
                                break;
                        }
                     //   die;
                        break;
                    
                    case "Disks":
                        $model = '\common\models\disks\Disk';
                        switch ($update){
                            case "brands":
                             $this->updateBrands($supplierModel, $type);
                        break;
                          case "models":
                               $this->updateModels($supplierModel,$type); 
                                // выбираем все модели дисков
                                                     
                            break;
                             case "items":
                                   $this->updateItems($supplierModel,$type);
                     
                                break;
                    case "prices":
                                  $this->updatePrices($supplierModel,$type);
                                break;
                        }
                        break;
                    case "Products":
                        $model = '\common\models\Product';
                        break;
                }
            
	
       return $this->redirect ( [
				'/suppliers/view',
				'supplier' => $supplier,
                                'type'=>$type,
		] ); 
         
        
               
}/**/

    private function getBrandID($brend,$tip){
        switch ($tip){
            case 'Tire':
                $model = '\common\models\tires\TireManufacturer';
                break;
        case 'Disk':
                $model = '\common\models\disks\DiskManufacturer';
                break;
        }
        $id = $model::find()
                                        ->select('id')
                                        ->where(['LOWER(title)'=>mb_convert_case($brend,MB_CASE_LOWER,'UTF-8')])
                                        ->one();
        if (isset($id->id) && isset($id->id))
        return $id->id;
                                       
    }/**/
    
    private function updateBrands($supplierModel, $type, $all = FALSE ){
        $count = 0;
        $errors = [];
        switch ($type){
            case "Tires":
               
            $column = 'tire_id';
            $model = '\common\models\tires\TireManufacturer';
             break;
            case "Disks":
               $column = 'disk_id';
               $model = '\common\models\disks\DiskManufacturer';
                break;
        }
                    $supBrands = $supplierModel::find()->select('DISTINCT(brend)')
                                    ->where('(:column IS Null OR :column = 0) ',[':column'=>$column])
                                    ->andWhere('brend IS NOT Null')
                                    ->asArray()
                                    ->all();
                      //  $brands = \common\models\tires\TireManufacturer::find()->select('DISTINCT(title)')->asArray()->all();
                        foreach($supBrands as $supBrand){
                           $brand = $model::find()
                                   ->where(['LOWER(title)' =>  mb_strtolower($supBrand['brend'],"UTF-8")])
                                   ->one();
                      
                           if (!isset($brand->id) || !$brand->id){
                                $brand = new $model;
                                $brand->title = $supBrand['brend'];
                             //   echo $brand->title.'<br/>';
                                if ($brand->save()){                
                                    $count++;
                                } else{
                                 $errors[] = $brand->errors;
                                }
                            }
                        }// end foreach
                        
                        $status = '';
                        $message = '';
                     //   var_dump($errors);die;
                        if (count($errors)== 0){
                          $status = 'success';
                          $message =  'Обновлено '.$count.' позиций производителей шин!';
                                 } elseif(count($errors) > 0){
                            $status = 'warning';
                            $message = 'Обновлено '.$count.' позиций производителей ! Ошибок: '.count($errors).PHP_EOL;
                            foreach ($errors as $k =>$errs){
                            foreach ($errs as $field => $error){
                                $message .= $error;
                            }
                           
                                
                            }    
                    }  else{
                        $status = 'info';
                        $message = 'Все бренды уже добалвены';
                            }
                      Yii::$app->session->setFlash ($status ,$message );   
    }/**/
    
    private function updateModels($supplierModel,$type, $all=FALSE){
              
        switch ($type){
            case "Tires":
            $singular = 'Tire';   
            $column = new \yii\db\Expression('tire_id');
            $model = '\common\models\tires\TireManufacturer';
            $fields = ['id','brend', 'model', 'sezon', 'tip_transportnogo_sredstva','fajjl_izobrazhenie'];
            $function = 'updateTireModels';
             break;
            case "Disks":
                    $singular = 'Disk';   
               $column = new \yii\db\Expression('disk_id');
               $model = '\common\models\disks\DiskManufacturer';
               $fields = ['id','brend', 'model', 'tip', 'color', 'kol_otverstiy', 'fajjl_izobrazhenie'];
                                                                   
                   $function = 'updateDiskModels';
                break;
        }
          // выбираем все модели
                        $supModels = $supplierModel::find()
                                    ->select($fields)
                                    ->where('('.$column.' IS Null OR '.$column.' = 0) ')
                                    ->asArray()
                                //    ->limit(1000)
                                    ->all();
  //   var_dump($supModels);die;         
                        $this->$function($supModels);
                     
    }/**/
    
    private function updateItems($supplierModel,$type){
          switch ($type){
            case "Tires":
            $singular = 'Tire';   
            $column = new \yii\db\Expression('tire_id');
            $model = '\common\models\tires\TireManufacturer';
            $fields = ['id','brend','model','tire_id',
                                              'sezon',
                                              'tip_transportnogo_sredstva',
                                              'shirina_profilya as width',
                                              'vysota_profilya as profile',
                                              'diametr_kolesa as diameter',
                                              'indeks_nagruzki as max_load',
                                              'indeks_skorosti as max_speed',
                                              'uslilennaya_shina as usilennaya',
                                              'ship_neship as ship',
                                              'tip_shiny'];
            $function = 'updateTireItems';
             break;
            case "Disks":
                    $singular = 'Disk';   
               $column = new \yii\db\Expression('disk_id');
               $model = '\common\models\disks\DiskManufacturer';
               $fields = ['id','brend','model','disk_id',
                                              'width',
                                              'diameter',
                                              'pcd1 as pcd',
                                              'pcd2',
                                              'stupitsa',
                                              'et',
                                              'tip',
                                              'color',
                                              'kol_otverstiy'
                                              ];
                                                                   
                   $function = 'updateDiskItems';
                break;
        }
        
       $supItems = $supplierModel::find()
                                    ->select($fields)
                                    ->orderBy($column.' ASC')
                                    ->where('('.$column.' IS Null OR '.$column.' = 0)')
                                    ->asArray()
                                    ->all();
    //  var_dump($supItems);die;
     
                      $this->$function($supItems,$supplierModel);
    }/**/
    
    private function updatePrices($supplierModel,$type){
        $message =  '';
        $status = '';
        $count = 0;
        $errors = [];
        
        switch( $type) {
            case "Tires":
                $id = 'tire_id';
                $column = new \yii\db\Expression('tire_id');  
                $model = '\common\models\tires\Tire';
               // ,[':column'=>new \yii\db\Expression($column)]
                break;
            
            case "Disks":
                  $id = 'disk_id';
                  $column = new \yii\db\Expression('disk_id');
                 $model = '\common\models\disks\Disk';
                break;
        }
          $supItems = $supplierModel::find()
                                    ->select([$column,'id',
                                              'vykhodnaya_roznichnaya_cena as price',
                                              'ostatok as quantity',
                                             ])
                                    ->where('('.$column.' > 0) AND (ostatok > 0) AND (vykhodnaya_roznichnaya_cena > 0)')
                                    ->orderBy($column.' DESC')
                              //      ->limit(1)
                                    ->asArray()
                                    ->all();
          
       
                                foreach($supItems as $supItem){
                                    $item = $model::find()
                                       //     ->select(['id','price','quantity'])
                                            ->where(['id'=>$supItem[$id]])
                                            ->one();
                                    if (isset($item->id) && $item->id){
                                     $item->attributes =$supItem;
                                   
                                     if ($item->save()){
                                         $count++;
                                     }else{
                                         $errors[$item->id] = $item->errors;
                                         var_dump($item);
                                     }
                                    }
                                    
                                }// endforeach
                                  if ($count > 0 && (count($errors)== 0)){
                                      $message =  'Обновлено '.$count.' цен наших шин! ';
                                      $status = 'success';
                          Yii::$app->session->setFlash ( $status, $message);
                        }else{
                            var_dump($errors);
                        }
         
                $this->_event = new \backend\events\UpdatePriceEvent();
                $this->_event->message = $message;
                $this->_event->status = $status;
                $this->_event->price = $type;
                $this->_event->supplier = $supplierModel;
             $this->on(self::EVENT_AFTER_UPDATE_PRICE, [$this->_event,self::EVENT_AFTER_UPDATE_PRICE]);
		 $this->trigger(self::EVENT_AFTER_UPDATE_PRICE, $this->_event);
                        
    }/**/
    
    private function updateTireModels($supModels){
          $count = 0;
          $status = '';
          $message = '';
        $errors = [];
                                    foreach ($supModels as $supTireModel){
                                $brandID = $this->getBrandID($supTireModel['brend'],'Tire');
                                if($brandID){
                                    $seazonID = \common\models\tires\TireSeason::find()
                                            ->select('id')
                                            ->where(['title'=>mb_convert_case($supTireModel['sezon'],MB_CASE_LOWER,'UTF-8')])
                                            ->orWhere(['singular'=>mb_convert_case($supTireModel['sezon'],MB_CASE_LOWER,'UTF-8')])
                                            ->one()
                                            ->id;
                                    $tipTrID = \common\models\tires\TireCarType::find()
                                            ->select('id')
                                            ->where(['title'=>mb_convert_case($supTireModel['tip_transportnogo_sredstva'],MB_CASE_LOWER,'UTF-8')])
                                         //   ->or_where(['singular'=>mb_convert_case($supTireModel['sezon'],MB_CASE_LOWER,'UTF-8')])
                                            ->one();
                                        if (isset($tipTrID->id)){
                                $tireModel = \common\models\tires\TireModel::find()
                                        ->select('id,title,brand_id,alias,image,thumbnail')
                                        ->where(['LOWER(title)'=>mb_convert_case($supTireModel['model'],MB_CASE_LOWER,'UTF-8')])
                                        ->andWhere(['brand_id'=>$brandID])
                                        ->andWhere(['season'=>$seazonID])
                                        ->andWhere(['car_type'=>$tipTrID->id])
                                     //   ->asArray()
                                        ->one();
                                        }else {
									//		echo "<pre>";
                                    //     var_dump($supTireModel); 
									//		echo "</pre>";										 
                                        }
                                // Если есть такая модель
                                if (isset ($tireModel->title) && $tireModel->title ){
                                    if(!$tireModel->image){
                    $this->updateImageFromFile($tireModel, $supTireModel['fajjl_izobrazhenie'],'Tires');
                                            }
                                    continue;
                                }
                                else {
                                    $tireModel = new \common\models\tires\TireModel();
                                    $tireModel->brand_id = $brandID;
                                    $tireModel->title = mb_convert_case($supTireModel['model'],MB_CASE_LOWER,'UTF-8');
                                    $tireModel->season = $seazonID;                               
                                    $tireModel->car_type = $tipTrID->id;
                                    
                                    if ($tireModel->validate()){
                                            $tireModel->save();
                                            $count++;
                                            if(!$tireModel->image){
                            $this->updateImageFromFile($tireModel, $supTireModel['fajjl_izobrazhenie'],'Tires');
                                            }
                                    }//end if validate
                                    else{
									//	var_dump($supTireModel);
                                        $errors[$supTireModel['id']]=$tireModel->errors;
                                    }
                                }
                               
                            }// end if brandID
                              else{
                            //      var_dump($supTireModel);die;
                        $status = 'danger';
                        $message .= 'Для шины '.$supTireModel['id'].' не найдены производитель'.PHP_EOL;
                       
                                 
                            }
                       //      var_dump($tireModel);
                            } // end foreach
                         
                           if ($count > 0 && (count($errors)== 0)){
                            $status = 'success';
                            $message .= 'Обновлено '.$count.' моделей наших шин! ';
                         
                        }  else {
							//var_dump($errors);die;
			$message = 'Обновлено '.$count.' моделей наших шин! '.PHP_EOL;
			$message .= 'Ошибок: '.count($errors).PHP_EOL;
			
							foreach ($errors as $smID =>$error){
			$message .= "ID модели Поставщика: ".$smID.PHP_EOL;
			
								foreach($error as $err){
									foreach ($err as $er){
			$message .= $er.PHP_EOL;
			
									}								
								}
							}
                                                        $status = 'warning';
                                                                        
                        }
                        $message = nl2br($message);
                          Yii::$app->session->setFlash ( $status, $message);   
                            
    }/**/
    
    private function updateTireItems($supItems,$supplierModel){
          $count = 0;
        $errors = [];
        $doubles =[];
        $excludes = [];
        $db = Yii::$app->db;
      
              foreach($supItems as $supItem){
                              $brandID = $this->getBrandID($supItem['brend'],'Tire');
                              if ($brandID){
                                  $season_id = $db
                                          ->createCommand('SELECT id FROM {{%tires_seasons}} WHERE title = :value OR singular = :value ')
                                          ->bindValue(':value',mb_convert_case($supItem['sezon'],MB_CASE_LOWER,'UTF-8'))
                                          ->queryScalar();
                                 
                           
                              $car_type_id = $db
                                          ->createCommand('SELECT id FROM {{%tires_cars_types}} WHERE title = :value')
                                          ->bindValue(':value',mb_convert_case($supItem['tip_transportnogo_sredstva'],MB_CASE_LOWER,'UTF-8'))
                                          ->queryScalar();
                             
                                
                                 if(!$car_type_id){
                               //      var_dump($supItem);die;
                                 }
                                 
                                 
                              $tire_model_id = $db
                                          ->createCommand('SELECT id FROM {{%tires_models}} '
                                                  .'WHERE LOWER(title) = :title '
                                                  .' AND season =:season AND car_type = :car_type AND brand_id = :brand_id')
                                          ->bindValue(':title',mb_convert_case($supItem['model'],MB_CASE_LOWER,'UTF-8'))
                                          ->bindValue(':season', $season_id)
                                          ->bindValue(':car_type', $car_type_id)
                                          ->bindValue(':brand_id', $brandID)
                                          ->queryScalar();
                           
                                 
                           if ($tire_model_id){
                            $model = \common\models\tires\Tire::find()
                                    ->select(['id','width','profile','diameter',
                                        'max_load','max_speed','usilennaya','ship','tip_shiny']);
                            $model       ->where(['model_id'=>$tire_model_id]);
                            if ($supItem['width'])
                            $model        ->andWhere(['width'=>$supItem['width']]);
                            
                            if ($supItem['profile'])
                            $model        ->andWhere(['profile'=>$supItem['profile']]);
                            
                            if ($supItem['diameter'])
                            $model        ->andWhere(['diameter'=>$supItem['diameter']]);
                            
                            if ($supItem['max_speed'])
                            $model        ->andWhere(['max_speed'=>$supItem['max_speed']]);
                            
                            if ($supItem['max_load'])
                            $model        ->andWhere(['max_load'=>$supItem['max_load']]);    
                            
                            if ($supItem['usilennaya'])
                            $model        ->andWhere(['usilennaya'=>$supItem['usilennaya']]);    
                            
                            if ($supItem['ship'])
                            $model        ->andWhere(['ship'=>$supItem['ship']]);    
                            
                            
                            $model        ->one();
                            
                            if (!isset($model->id) || !$model->id){
                                $model = new \common\models\tires\Tire ();
                            }
                                $supItem['model_id'] = $tire_model_id;
                           //     var_dump($supItem);
                            $model->attributes = $supItem;
                            if (!in_array($model->id, $excludes)){
                        if ($model->validate()) {
                         if ($model->save()){
                             $excludes[]=$model->id;
                      //   var_dump($model->attributes);
                                  $count++;  
                                  // если нет нашего ID в прайсе поставщика
                                  if (!$supItem['tire_id']){
                                      $supplier_tire_id = $db
                                          ->createCommand('SELECT tire_id FROM {{%tire_trader_tires}} WHERE id = :id')
                                          ->bindValue(':id',$supItem['id'])
                                          ->queryScalar();
                                     $update =	$db->createCommand()
                                        ->update($supplierModel::tableName(), ['tire_id'=> $model->id], 'id = '.$supItem['id'])
                                        ->execute();       
                                     if( !$update){
                                //      var_dump($update);
                                     }
                                  }
                         }
                        } else {
                        // validation failed: $errors is an array containing error messages
                        $errors[$model->id] = $model->errors;
                      //  var_dump($errors);
                        }
                       //     var_dump($model);
                            }// end if in excludes
                            else {
                                $doubles[] = 'Попытка создания дубликата нашей позиции.'.PHP_EOL
                                        .'Наш ID'.$model->id.'('.$model->tireModel->fullTitle.')'
                                        . ' ID поставщика '.$supItem['id'].PHP_EOL;
                            }
                                }// end if model ID
                                
                        }// end if brand ID
                        }// end foreach supItems
                        $message = '';
                        $status = '';
                  if ($count > 0 && (count($errors)== 0) && (count($doubles)== 0) ){
                      $status = 'success';
                      $message =  'Обновлено '.$count.' позиций наших шин! ';
                        
                 } else {
                        $status = 'warning';
                            $message .= 'Обновлено '.$count.' позиций наших шин!'.PHP_EOL;
                 if (count($doubles)> 0) {
                  
                            $message .= 'Найдено '.count($doubles).' дубликатов '.PHP_EOL;
                            foreach($doubles as $double){
                             $message .= $double;   
                            }
                     
                           
                        } // end if doubles  
                         if (count($errors)> 0) {
                   
                            $message .= 'Найдено '.count($errors).' дубликатов '.PHP_EOL;
                            foreach($errors as $k => $err){
                                  foreach($err as $field => $error){
                             $message .= $k.' '.$error;   
                            }
                            }
                           
                        } // end if errors
                 }
                        $message = nl2br($message);
           Yii::$app->session->setFlash ( $status, $message);
    }/**/
    
    private function updateDiskItems($supItems,$supplierModel){
   
                        foreach($supItems as $supItem){
                              $brandID = $this->getBrandID($supItem['brend'],'Disk');
                               
                             $modelDisk = \common\models\disks\DiskModel::find();
                             $modelDisk    ->select('id,title,brand_id');
                             $modelDisk   ->where(['LOWER(title)'=>mb_convert_case($supItem['model'],MB_CASE_LOWER,'UTF-8')]);
                             $modelDisk  ->andWhere(['brand_id'=>$brandID]);
                              
                             if ($supItem['tip'])
                                 $modelDisk->andWhere(['tip'=>$supItem['tip']]);
                             
                             if ($supItem['color'])
                                  $modelDisk->andWhere(['color'=>$supItem['color']]);
                             
                             if ($supItem['kol_otverstiy'])
                                  $modelDisk->andWhere(['kol_otverstiy'=>$supItem['kol_otverstiy']]);
                             
                               $modelID = $modelDisk->one();
                       //        var_dump($supplier); var_dump($supItem);die;
                                if (isset($modelID->id) && $modelID->id){
                            //         var_dump($modelID);die;
                            $model = \common\models\disks\Disk::find()
                                    ->select(['id','width',
                                              'diameter',
                                              'pcd',
                                              'pcd2',
                                              'stupitsa',
                                              'et'])
                                    ->where(['model_id'=>$modelID->id])
                                    ->andWhere(['width'=>$supItem['width']])
                                    ->andWhere(['et'=>$supItem['et']])
                                    ->andWhere(['diameter'=>$supItem['diameter']])
                                    ->andWhere(['pcd'=>$supItem['pcd']])
                                    ->andWhere(['pcd2'=>$supItem['pcd2']])
                                    ->andWhere(['stupitsa'=>$supItem['stupitsa']])
                                    ->one();
                            if (!isset($model->id) || !$model->id)
                                $model = new \common\models\disks\Disk();
                                $supItem['model_id'] = $modelID->id;
                           //     var_dump($supItem);
                                unset($supItem['kol_otverstiy']);
                                unset($supItem['color']);
                                unset($supItem['tip']);
                            $model->attributes = $supItem;
                           // var_dump($model->attributes);
                        if ($model->validate()) {
                         if ($model->save()){
                         
                                  $count++;  
                                  // если нет нашего ID в прайсе поставщика
                                  if (!$supItem['disk_id']){
                                      $supplier = $supplierModel::find()->select(['id','disk_id'])
                                              ->where(['id'=>$supItem['id']])
                                              ->one();
                                      $supplier->disk_id = $model->id;
                                     if( !$supplier->save()){
                                      //    var_dump($model);
                                      //   var_dump($supplier->errors);
                                     }
                                  }
                         } else{
                             $errors[$model->id] = $model->errors;
                         }
                        } else {
                        // validation failed: $errors is an array containing error messages
                        $errors[$model->id] = $model->errors;
                      
                        }
                       //     var_dump($model);
                        }// end if model ID
                        }// end foreach supItems
                  if ($count > 0 && (count($errors)== 0)){
                          Yii::$app->session->setFlash ( 'success', 'Обновлено '.$count.' позиций наших дисков! ' );
                        } else {
                    Yii::$app->session->setFlash ( 'warning', 'Обновлено '.$count.' позиций наших дисков! '
                               . 'Ошибок: '.count($errors) );              
                        }
                      
    }/**/
    
    private function updateDiskModels($supModels){
         $count = 0;
        $errors = [];
                        foreach ($supModels as $supDiskModel){
                                $brandID = $this->getBrandID($supDiskModel['brend'],'Disk');
                                if($brandID){
                                   
                                $diskModel = \common\models\disks\DiskModel::find()
                                        ->select('id,title,brand_id,alias,image,thumbnail')
                                        ->where(['LOWER(title)'=>mb_convert_case($supDiskModel['model'],MB_CASE_LOWER,'UTF-8')])
                                        ->andWhere(['brand_id'=>$brandID])
                                        ->andWhere(['tip'=>$supDiskModel['tip']])
                                        ->andWhere(['color'=>$supDiskModel['color']])
                                        ->andWhere(['kol_otverstiy'=>$supDiskModel['kol_otverstiy']])
                                       
                                     //   ->asArray()
                                        ->one();
                                 
                                // Если есть такая модель
                                if ($diskModel->id ){
                                      if(!$diskModel->image){
                            $this->updateImageFromFile($diskModel, $supDiskModel['fajjl_izobrazhenie'],'Disks');
                                            }
                                    continue;
                                }
                                else {
                                    $diskModel = new \common\models\disks\DiskModel();
                                    $diskModel->brand_id = $brandID;
                                    $diskModel->title = mb_convert_case($supDiskModel['model'],MB_CASE_LOWER,'UTF-8');
                                   
                                    $diskModel->tip = $supDiskModel['tip'];
                                    $diskModel->color = $supDiskModel['color'];
                                    $diskModel->kol_otverstiy = $supDiskModel['kol_otverstiy'];
                                   
                                    if ($diskModel->validate()){
                                            if($diskModel->save()){
                                            $count++;
                                             if(!$diskModel->image){
                            $this->updateImageFromFile($diskModel, $supDiskModel['fajjl_izobrazhenie'],'Disks');
                                            }
                                            }  else {
                                            var_dump($diskModel->errors);    
                                            }
                                    }//end if validate
                                    else{
                                        $errors[]=$diskModel->errors;
                                    }
                                }
                               
                            }//end if brandID
                             else{
                        
                          Yii::$app->session->setFlash ( 'danger', 'Для некоторых шин не найдены производители  ' );
                                 
                            }
                       //      var_dump($tireModel);
                            }// end foreach

                           if ($count > 0 && (count($errors)== 0)){
                          Yii::$app->session->setFlash ( 'success', 'Обновлено '.$count.' моделей наших дисков! ' );
                        }  else {
                       Yii::$app->session->setFlash ( 'warning', 'Обновлено '.$count.' моделей наших дисков! '
                               . 'Ошибок: '.count($errors) );      
                        }       
    }
    /*
     * Обновляем изображение для позиции
     *       
     */
    
    private function updateImageFromFile($model,$imageFile,$tip){
       
        switch ($tip){
            case "Tires":
                $imageFolder = 'tires';
                break;
            case "Disks":
                $imageFolder = 'disks';
                break;
            case "Products":
                $imageFolder = 'products';
                break;
        }
         $imagePath = Yii::getAlias ( '@root' ).'/uploads/'.$imageFolder.'/'.$imageFile;
        if (file_exists($imagePath) && is_file($imagePath) ){
    		$filePath = Yii::getAlias ( '@frontend' ) . '/web/images/'.$imageFolder.'/'.$model->brand->alias.'/';
    		if (!is_dir($filePath)){
    			mkdir($filePath,0777);
    		}
                $filePath .= $model->alias.'/';
    		if (!is_dir($filePath)){
    			mkdir($filePath,0777);
    		}
                 
                $ext = substr($imageFile,-3);
                if ($ext == 'jpe')$ext = substr($imageFile,-4);
            //    var_dump($ext);die;
    		//	echo phpversion("imagick");die;
    		$imageFile = $filePath.$model->alias.'-'.$model->id. '.' . $ext;
    		if (copy ( $imagePath,$imageFile  )){
    		$model->image = $model->alias.'-'.$model->id. '.' . $ext;
    		$thumb = \yii\imagine\Image::thumbnail($imageFile,131,173);
    		$thumbFile = $model->alias.'-'.$model->id . '_thumb.' . $ext;
               //     var_dump($filePath .$thumbFile);
    		if ($thumb->save($filePath . $thumbFile))
    		$model->thumbnail = $thumbFile;
    		if ($model->save())
                        unlink($imagePath);
                }
    	
    	}
     
    } /**/

}/*end of Controller*/
