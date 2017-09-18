<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `\common\models\Order`.
 */
class OrderSearch extends Order
{
    public $month;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'sposob_oplati', 'sposob_dostavki', 'created', 'updated', 'manager_id', 'email'], 'integer'],
            [['suma'], 'number'],
            [['payment_status', 'delivery_status', 'memo','month'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'suma' => $this->suma,
            'sposob_oplati' => $this->sposob_oplati,
            'sposob_dostavki' => $this->sposob_dostavki,
            'created' => $this->created,
            'updated' => $this->updated,
            'manager_id' => $this->manager_id,
            'email' => $this->email,
        ]);

        $query->andFilterWhere(['like', 'payment_status', $this->payment_status])
            ->andFilterWhere(['like', 'delivery_status', $this->delivery_status])
            ->andFilterWhere(['like', 'memo', $this->memo]);

       if ($this->month){
           $query->andWhere('FROM_UNIXTIME(created, \'%Y-%m\') >= :month
AND FROM_UNIXTIME(created, \'%Y-%m\') <= :month',[':month'=>$this->month]);
       }

        return $dataProvider;
    }/**/
    
}/* end of Model */
