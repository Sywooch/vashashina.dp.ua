<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * Site controller
 */
class SiteController extends Controller
{
	public $layout = 'default';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
           /* 'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
  //      $this->layout = 'indexPage';
     // $query =\common\models\tires\Tire::find()->limit(6);//->limit(Yii::$app->params['defaultPageSize'])->orderBy('created DESC')->all();

    //   $query->limit = 6;
      //    var_dump($query);die;
       $dataProvider = new ActiveDataProvider([
    'query' =>  \common\models\tires\Tire::find()->orderBy('created DESC'),
    'pagination'=>['pageSize'=>6],
     'sort'=>[
          'attributes'=>[
             'created'=>['default'=>SORT_DESC]],
         ],
     'totalCount'=>6
    ]);
      
        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }/**/

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
            	$model->sendEmail();
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

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
    }

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
    
    public function actionPages($page_alias = ''){
        $view = 'page';
        $model = \common\models\Page::find()->where('alias =:page_alias',[':page_alias'=>$page_alias])->one();
        if (!$model){
            throw new NotFoundHttpException();
        }
        if ($model->alias == 'contacts'){
            $view = 'contact';
        }
           
          return $this->render($view, [
            'model' => $model,
        ]);
    }/**/
    public function actionNews($news_alias = ''){
        if ($news_alias){
        $model = \common\models\News::find()->where('alias =:news_alias',[':news_alias'=>$news_alias])->one();
        if (!$model){
            throw new NotFoundHttpException();
        }
           
          return $this->render('newsView', [
            'model' => $model,
        ]);
        }else{
         if (Yii::$app->request->get('per-page') || Yii::$app->request->get('per-page') == 0){
            Yii::$app->session['perPage'] = Yii::$app->request->get('per-page');
        }
         if (!isset(Yii::$app->session['perPage'])){
          Yii::$app->session['perPage'] = 9;  
        }
             $query = \common\models\News::find()->orderBy('created DESC');
    $countQuery = clone $query;
     $count = $countQuery->count();
    $pages = new \yii\data\Pagination(['totalCount' => $count,
    'pageSize'=>(isset(Yii::$app->session['perPage']))?Yii::$app->session['perPage']+1:10]);

    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

    return $this->render('news', [
         'models' => $models,
         'pages' => $pages,
         'count' => $count
    ]);
          
           
        }
    }/**/
    
        public function actionArticles($article_alias = ''){
        if ($article_alias){
        $model = \common\models\Article::find()->where('alias =:article_alias',[':article_alias'=>$article_alias])->one();
        if (!$model){
            throw new NotFoundHttpException();
        }
           
          return $this->render('articleView', [
            'model' => $model,
        ]);
        }else{
         if (Yii::$app->request->get('per-page') || Yii::$app->request->get('per-page') == 0){
            Yii::$app->session['perPage'] = Yii::$app->request->get('per-page');
        }
         if (!isset(Yii::$app->session['perPage'])){
          Yii::$app->session['perPage'] = 9;  
        }
             $query = \common\models\Article::find()->orderBy('created DESC');
    $countQuery = clone $query;
    $count = $countQuery->count();
    $pages = new \yii\data\Pagination(['totalCount' => $count,
    'pageSize'=>(isset(Yii::$app->session['perPage']))?Yii::$app->session['perPage']+1:10]);

    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

    return $this->render('articles', [
         'models' => $models,
         'pages' => $pages,
         'count' => $count
    ]);
          
           
        }
    }/**/  

    public function actionSearch($q = ''){
        $data['tires'] = \common\models\tires\TireModel::find()
           //     ->select(['vs_tires_models.*','vs_tires_manufactures.*',])
                ->joinWith('brand')
                ->orFilterWhere(['like','vs_tires_manufactures.title',$q])
                ->orFilterWhere(['like','vs_tires_models.title',$q])
            //    ->addParams([':q'=>$q])
                ->all();
        $data['disks'] = \common\models\disks\DiskModel::find()
      //          ->select('vs_disks_models.title,vs_disks_manufactures.title,vs_disks_models.alias,vs_disks_manufactures.alias')
                ->joinWith('brand')
                ->orFilterWhere(['like','vs_disks_manufactures.title',$q])
                ->orFilterWhere(['like','vs_disks_models.title',$q])
            //    ->addParams([':q'=>$q])
                ->all();
        $data['q'] = $q;
    	
    	return $this->render('search',$data);
    }/**/
    
    public function actionHtml($view){
        return $this->renderPartial($view);
    }/**/
    
    public function actionPodborPoAvto($type = false){
        $data = [];
        if (Yii::$app->request->isAjax){
        switch($type){
            case "model":
        $vendor = Yii::$app->request->post('vendor');
       $carModels = \yii\helpers\ArrayHelper::map(\common\models\PodborShiniDiski::find()
            ->select('DISTINCT(car)')
            ->orderBy(['car'=>'ASC'])
            ->where('car IS NOT NULL AND TRIM(IFNULL(car,"")) <> ""')
            ->andWhere('vendor = :vendor',[':vendor'=>$vendor])
            ->asArray()
            ->all(),'car','car');
       $data['cars'] = \yii\helpers\Html::dropDownList('PodborShiniDiski[carModel]','',$carModels,
    ['class'=>'dropdown','prompt'=>'Любая','id'=>'carModel']);
        break;
            case "mod":
            $vendor = Yii::$app->request->post('vendor');
            $carModel = Yii::$app->request->post('carModel');
       $carsMod = \yii\helpers\ArrayHelper::map(\common\models\PodborShiniDiski::find()
            ->select('DISTINCT(modification)')
            ->orderBy(['modification'=>'ASC'])
            ->where('modification IS NOT NULL AND TRIM(IFNULL(modification,"")) <> ""')
            ->andWhere('vendor = :vendor',[':vendor'=>$vendor])
            ->andWhere('car = :car',[':car'=>$carModel])
            ->asArray()
            ->all(),'modification','modification');
       $data['carsMod'] = \yii\helpers\Html::dropDownList('PodborShiniDiski[carMod]','',$carsMod,
    ['class'=>'dropdown','prompt'=>'Любая','id'=>'carMod']);
        break;
    
        case "year":
            $vendor = Yii::$app->request->post('vendor');
            $carModel = Yii::$app->request->post('carModel');
            $carMod = Yii::$app->request->post('carMod');
       $carsYear = \yii\helpers\ArrayHelper::map(\common\models\PodborShiniDiski::find()
            ->select('DISTINCT(year)')
            ->orderBy(['year'=>'ASC'])
            ->where('year IS NOT NULL AND TRIM(IFNULL(year,"")) <> ""')
            ->andWhere('vendor = :vendor',[':vendor'=>$vendor])
            ->andWhere('car = :car',[':car'=>$carModel])
            ->andWhere('modification = :mod',[':mod'=>$carMod])
            ->asArray()
            ->all(),'year','year');
       $data['carsYear'] = \yii\helpers\Html::dropDownList('PodborShiniDiski[carYear]','',$carsYear,
    ['class'=>'dropdown','prompt'=>'Любой','id'=>'carYear']);
        break;   
  
        }
         echo \yii\helpers\Json::encode($data);
        } else {
        	$vendor = Yii::$app->request->get('PodborShiniDiski')['vendor'];
        	$carModel = Yii::$app->request->get('PodborShiniDiski')['carModel'];
        	$carMod = Yii::$app->request->get('PodborShiniDiski')['carMod'];
        	$year = Yii::$app->request->get('PodborShiniDiski')['carYear'];
        	if ($vendor && $carModel && $carMod && $year){
        		$data['podbor'] = \common\models\PodborShiniDiski::find()
         //   ->select('DISTINCT(year)')
         //   ->orderBy(['year'=>'ASC'])
         //   ->where('year IS NOT NULL AND TRIM(IFNULL(year,"")) <> ""')
            ->andWhere('vendor = :vendor',[':vendor'=>$vendor])
            ->andWhere('car = :car',[':car'=>$carModel])
            ->andWhere('modification = :mod',[':mod'=>$carMod])
            ->andWhere('year = :year',[':year'=>$year])
            ->asArray()
            ->one()  ;

        		$data['zavodTires'] = FALSE;
        		$data['zamenaTires'] = FALSE;
        		$data['tuningTires'] = FALSE;
        		if ($data['podbor']['zavod_shini']){
        	$data['zavodTires'] = explode('|', $data['podbor']['zavod_shini']);} 
        		if ($data['podbor']['zamen_shini'])
        	$data['zamenaTires'] = explode('|', $data['podbor']['zamen_shini']);
        		if ($data['podbor']['tuning_shini'])
        	$data['tuningTires'] = explode('|', $data['podbor']['tuning_shini']);
        	
        		$data['zavodDisks'] = FALSE;
        		$data['zamenaDisks'] = FALSE;
        		$data['tuningDisks'] = FALSE;
        		
        	$data['zavodDisks'] = explode('|', $data['podbor']['zavod_diskov']);
        	$data['zamenaDisks'] = explode('|', $data['podbor']['zamen_diskov']);
        	$data['tuningDisks'] = explode('|', $data['podbor']['tuning_diski']);
        	        	}
        	        	
        	return $this->render('podbor-po-avto',$data);
            
        }
    }/**/
    
    public function actionAddComment(){
        $model = new \common\models\Comment;
        $model->load(Yii::$app->request->post());
        switch($model->category_id){
            case '1':
                $tire = \common\models\tires\Tire::findOne((int)$model->item_id);
                
                break;
            case "13":
                
            default :
                break;
        }
        var_dump($model->validate());
        
    }/**/
    
}/**/
