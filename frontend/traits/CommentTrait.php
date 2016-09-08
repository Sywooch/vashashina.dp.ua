<?php namespace frontend\traits;
use Yii;
trait CommentTrait
{
    public function getComments($model) {
   //    echo  $this->tab; die;// = 'comment';
        $commentModel = new \common\models\Comment();
      if (!Yii::$app->user->isGuest){
          $user = \common\models\User::findOne(Yii::$app->user->id);
          $commentModel->author = $user->name;
           $commentModel->author_email= $user->email;
      }
        if ($commentModel->load(Yii::$app->request->post())){
          //  var_dump($commentModel->captcha);die;
            if ($commentModel->save()){
              Yii::$app->session->setFlash ( 'success', 'Ваш коментарий успешно добавлен!' );  
               $commentModel->text = FALSE;
               $commentModel->captcha = FALSE;
             
            }else {
               Yii::$app->session->setFlash ( 'error', 'При добавлении комментария возникли ошибки!' );   
         //   var_dump($commentModel->getErrors());die;
               
            }
           $this->tab = 'comment';
        }
          $commentModel->category_id = $model->category_id;
          $commentModel->item_id = $model->id;
    	$commentsQuery = \common\models\Comment::find()
                ->where(['category_id'=>$model->category_id,'item_id'=>$model->id])
                ->orderBy('created DESC');
        $countQuery = clone $commentsQuery;
        $data['countComments'] = $countQuery->count();
         $data['commentModel']  = $commentModel;      
         $commentsQuery->limit(5);
         $data['comments'] =  $commentsQuery->all(); 
         return $data;
    }
}/*end of trait*/