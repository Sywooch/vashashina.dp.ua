<?php namespace frontend\widgets\shortArticles;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\Article;

class ShortArticles extends Widget
{
    public $count;
    public $limit = 2;

    public function init()
    {
        parent::init();
        if ($this->count === null) {
            $this->count = Article::find()->count();
        }
    }

    public function run()
    {
        $data = [];
        $data['articles'] = Article::find()->select('id,title,alias,text,created')
                ->orderBy('created DESC')->limit($this->limit)->all();
        return $this->render('index',$data);
    }
}/* end of Widget*/
