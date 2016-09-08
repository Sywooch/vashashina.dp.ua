<?php

namespace backend\controllers;

use Yii;
use common\models\tires\TireManufacturer;
use backend\models\search\tires\TireManufacturerSearch;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TiremanufacturerController implements the CRUD actions for TireManufacturer model.
 */
class TireManufacturerController extends AdminController
{
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
     * Lists all TireManufacturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TireManufacturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TireManufacturer model.
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
     * Creates a new TireManufacturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TireManufacturer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TireManufacturer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TireManufacturer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }/**/
    
    public function actionGetBrandModels($id){
        $id = (Yii::$app->request->post('id'))
                ? Yii::$app->request->post('id'):$id;
       
        $query = \common\models\tires\TireModel::find();
            $query ->select(['id','title']);
             if ($id){
              $query ->where('brand_id = :id', [':id'=>$id]);
             } 
              $query ->orderBy(['title'=>'ACS']);
                $query ->asArray();
                $models =   $query ->all();
        $select = \yii\helpers\Html::dropDownList('TireSearch[tireModel]','',
                \yii\helpers\ArrayHelper::map($models, 'id', 'title'),
                ['class'=>'form-control','prompt'=>Yii::t('app','Models')]);
        echo $select;
    }/**/

    /**
     * Finds the TireManufacturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TireManufacturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TireManufacturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
