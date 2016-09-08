<div class="col-sm-12">
    <div class="row">
           <?php echo \common\models\Page::find()
                ->select('content')
                ->where(['alias' => 'garantia'])
                ->one()
                ->content;?>    
    </div>
</div>