<?php

namespace backend\controllers;

use Yii;
use common\models\ProductParam;
use backend\models\search\ProductParamSearch;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductParamController implements the CRUD actions for ProductParam model.
 */
class ProductParamController extends AdminController
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
     * Lists all ProductParam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductParamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductParam model.
     * @param integer $product_id
     * @param integer $param_id
     * @param string $value
     * @return mixed
     */
    public function actionView($product_id, $param_id, $value)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $param_id, $value),
        ]);
    }

    /**
     * Creates a new ProductParam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductParam();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'param_id' => $model->param_id, 'value' => $model->value]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductParam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $param_id
     * @param string $value
     * @return mixed
     */
    public function actionUpdate($product_id, $param_id, $value)
    {
        $model = $this->findModel($product_id, $param_id, $value);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'param_id' => $model->param_id, 'value' => $model->value]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductParam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $param_id
     * @param string $value
     * @return mixed
     */
    public function actionDelete($product_id, $param_id, $value)
    {
        $this->findModel($product_id, $param_id, $value)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductParam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $param_id
     * @param string $value
     * @return ProductParam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $param_id, $value)
    {
        if (($model = ProductParam::findOne(['product_id' => $product_id, 'param_id' => $param_id, 'value' => $value])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
