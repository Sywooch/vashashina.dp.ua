<?php namespace frontend\widgets\shortNews;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\News;

class ShortNews extends Widget
{
    public $count;
    public $limit = 2;

    public function init()
    {
        parent::init();
        if ($this->count === null) {
            $this->count = News::find()->count();
        }
    }

    public function run()
    {
        $data = [];
        $data['news'] = News::find()->select('id,title,alias,created')->orderBy(['created'=>'desc'])->limit($this->limit)->all();
        return $this->render('index',$data);
    }
}/* end of Widget*/
