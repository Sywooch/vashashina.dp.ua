<?php

namespace backend\models\search\tires;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\TireMaxSpeed;

/**
 * TireMaxSpeedSearch represents the model behind the search form about `backend\models\TireMaxSpeed`.
 */
class TireMaxSpeedSearch extends TireMaxSpeed
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'speed', 'status'], 'integer'],
            [['index'], 'safe'],
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
        $query = TireMaxSpeed::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'speed' => $this->speed,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'index', $this->index]);

        return $dataProvider;
    }
}
