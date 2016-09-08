<?php

namespace backend\models\search\tires;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\TireMaxLoad;

/**
 * TireMaxLoadSearch represents the model behind the search form about `backend\models\TireMaxLoad`.
 */
class TireMaxLoadSearch extends TireMaxLoad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['index', 'status'], 'safe'],
            [['max_load'], 'number'],
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
        $query = TireMaxLoad::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'max_load' => $this->max_load,
        ]);

        $query->andFilterWhere(['like', 'index', $this->index])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
