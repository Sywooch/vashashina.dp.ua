<?php
namespace backend\controllers;

use yii;
use backend\components\AdminController;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;


/**
 * Site controller
 */
class SiteController extends AdminController
{
	public $layout = 'main_empty';
    /**
     * @inheritdoc
     */


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            //	'layout'=> 'main_empty',
            ],
        ];
    }

    public function actionIndex()
    {
        $queryOrders = \common\models\Order::find()
                ->where('payment_status = "pending"')->orderBy('created Desc')
                ->limit(5);
        $ordersProvider = new \yii\data\ActiveDataProvider([
    			'query' =>  $queryOrders,
    			'pagination'=>['pageSize'=>6],
    			    ]);
    	
    	$this->layout = 'main';
        return $this->render('index',['ordersProvider'=>$ordersProvider]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
	//	$this->layout = 'main_empty';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }/**/
    
    public function actionPhpInfo(){
        return $this->render('phpinfo');
    }/**/
    
      public function actionRequestPasswordReset()
    {
      
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }/**/

    public function actionResetPassword($token)
    {
     
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }/**/
 
    
}/**/
