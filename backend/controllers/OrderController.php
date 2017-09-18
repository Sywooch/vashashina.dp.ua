<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use common\models\ProductsPerOrder;
use backend\models\search\OrderSearch;
use backend\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends AdminController
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $orderSum = $this->getSumOfOrders($dataProvider);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'orderSum' => $orderSum
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	 $query = \common\models\ProductsPerOrder::find();
        $query->where(['order_id'=>$id]);
    	$productsProvider = new ActiveDataProvider([
    			'query' =>  $query,
    			'pagination'=>['pageSize'=>6],
    			    ]);
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'productsProvider' =>$productsProvider
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
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
     * cancel an existing Order .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id)
    {
    	$this->findModel($id)->cancel();
    Yii::$app->session->setFlash ( 'warning', 'Заказ №'.$id.' был отменен!' );
    	return $this->redirect(['index']);
    }
    
        /**
     * completing an existing Order .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionComplete($id)
    {
    	$this->findModel($id)->complete();
       Yii::$app->session->setFlash ( 'success', 'Заказ №'.$id.' успешно выполнен!' );
    
    	return $this->redirect(['index']);
    }
    

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }/**/
    
    public function actionUpdateItems($product_id,$order_id){

        if (Yii::$app->request->isAjax){

            $model = ProductsPerOrder::find()
                ->where(['product_id'=>$product_id,'order_id'=>$order_id])
                ->one();
            // echo $model->id;die;
            if ($model->load(Yii::$app->request->post())  ) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Данные успешно обновлены');
                } else {
                    Yii::$app->session->setFlash('danger', 'Приобновлении данных произошла ошибка');
                }
            }

            return $this->renderAjax('_formAjax', [
                'model' => $model,
            ]);
        } else{
            \yii\helpers\VarDumper::dump($_REQUEST);
        }

    }/**/

    public function actionDeleteItems($product_id,$order_id){
        $model = ProductsPerOrder::find()
            ->where(['product_id'=>$product_id,'order_id'=>$order_id])
            ->one();
        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Данные успешно удалены');
        }
        return $this->redirect(['view','id'=>$order_id]);
    }/**/

    public function actionGetTotalSum($order_id){
        if (($model = Order::findOne($order_id)) !== null) {
            return $model->suma;
        }
    }/**/
    
    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }/**/

    private function getSumOfOrders($dataProvider){
        $sum = 0;
        foreach ($dataProvider->getModels() as $model){
            $sum += $model->suma;
        }

        return $sum;
    }/**/

}/* end of Controller */
