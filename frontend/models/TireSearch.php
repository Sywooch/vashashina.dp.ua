<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\Tire;

/**
 * TireSearch represents the model behind the search form about `app\models\Tire`.
 */
class TireSearch extends Tire
{
	public $tireWidth;
	public $tireProfile;
	public $tireRadius;
	public $tireMaxSpeed;
	public $tireMaxLoad;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'width_id', 'profile_id', 'diameter_id', 'max_load_id', 'max_speed_id', 'quantity', 'category_id', 'discount_begin', 'discount_end', 'status', 'created', 'updated', 'created_by', 'update_by'], 'integer'],
            [['full_title', 'ship', 'usilennaya','tireWidth','tireProfile',
            		'tireRadius','tireMaxSpeed','tireMaxLoad'
            ], 'safe'],
            [['price', 'discount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function attributeLabels()
    {
    	return [
    			
    			'width' => Yii::t('tires', 'Width'),
    			'profile' => Yii::t('tires', 'Profile'),
    			'diameter' => Yii::t('tires', 'Diameter'),
    			'max_load' => Yii::t('tires', 'Max Load'),
    			'max_speed' => Yii::t('tires', 'Max Speed'),
    			
    	];
    }/**/

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$model_id)
    {
        $query = Tire::find()->where('model_id = :model_id',[':model_id'=>$model_id]);
        
    //    $query->joinWith(['tireWidth','tireProfile', 'tireRadius','tireMaxSpeed','tireMaxLoad']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
    

    /*    $dataProvider->sort->attributes['tireWidth'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_width.width' => SORT_ASC],
        		'desc' => ['vs_tires_width.width' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['tireProfile'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_profiles.profile' => SORT_ASC],
        		'desc' => ['vs_tires_profiles.profile' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['tireRadius'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_radius.radius' => SORT_ASC],
        		'desc' => ['vs_tires_radius.radius' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['tireMaxSpeed'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_max_speed.speed' => SORT_ASC],
        		'desc' => ['vs_tires_max_speed.speed' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['tireMaxLoad'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_max_load.max_load' => SORT_ASC],
        		'desc' => ['vs_tires_max_load.max_load' => SORT_DESC],
        ];
        
        */
            $dependency = new \yii\caching\DbDependency(['sql'=>'SELECT max(updated) FROM '.
          self::tableName()]);
       Yii::$app->db->cache(function ($db) use ($dataProvider) {
      return $dataProvider->prepare();
        },60*60*24,$dependency);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
       


        return $dataProvider;
    }
}
