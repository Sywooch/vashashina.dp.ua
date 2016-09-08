<?php

namespace backend\models\search\tires;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\TireWidth;

/**
 * TireWidthSearch represents the model behind the search form about `backend\models\TireWidth`.
 */
class TireWidthSearch extends TireWidth
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['width'], 'number'],
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
        $query = TireWidth::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'width' => $this->width,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
