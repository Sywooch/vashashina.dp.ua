<?php

namespace backend\models\suppliers\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\suppliers\TireTraderTires;
use yii\helpers\Html;

/**
 * TireTraderSearch represents the model behind the search form about `backend\models\suppliers\TireTrader`.
 */
class TireTraderTiresSearch extends TireTraderTires
{
	public $tire;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tire_id', 'ostatok', 'status', 'created_at', 'updated_at', 'created_by', 'LastUpdatedBy'], 'integer'],
            [['brend', 'model', 'nazvanie', 'sezon', 'tip_transportnogo_sredstva', 'tip_shiny', 'shirina_profilya', 'vysota_profilya', 'diametr_kolesa', 'indeks_nagruzki', 'indeks_skorosti', 'uslilennaya_shina', 'ship_neship', 'data_obnovleniya_sklada', 'postavshhik', 'gorod', 'fajjl_izobrazhenie'], 'safe'],
            [['optovaya_iskhodnaya_cena', 'roznichnaya_iskhodnaya_cena', 'vykhodnaya_optovaya_cena', 'vykhodnaya_roznichnaya_cena', 'skidka'], 'number'],
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
        $query = TireTraderTires::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tire_id' => $this->tire_id,
            'data_obnovleniya_sklada' => $this->data_obnovleniya_sklada,
            'ostatok' => $this->ostatok,
            'optovaya_iskhodnaya_cena' => $this->optovaya_iskhodnaya_cena,
            'roznichnaya_iskhodnaya_cena' => $this->roznichnaya_iskhodnaya_cena,
            'vykhodnaya_optovaya_cena' => $this->vykhodnaya_optovaya_cena,
            'vykhodnaya_roznichnaya_cena' => $this->vykhodnaya_roznichnaya_cena,
            'skidka' => $this->skidka,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'LastUpdatedBy' => $this->LastUpdatedBy,
        ]);

        $query->andFilterWhere(['like', 'brend', $this->brend])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'nazvanie', $this->nazvanie])
            ->andFilterWhere(['like', 'sezon', $this->sezon])
            ->andFilterWhere(['like', 'tip_transportnogo_sredstva', $this->tip_transportnogo_sredstva])
            ->andFilterWhere(['like', 'tip_shiny', $this->tip_shiny])
            ->andFilterWhere(['like', 'shirina_profilya', $this->shirina_profilya])
            ->andFilterWhere(['like', 'vysota_profilya', $this->vysota_profilya])
            ->andFilterWhere(['like', 'diametr_kolesa', $this->diametr_kolesa])
            ->andFilterWhere(['like', 'indeks_nagruzki', $this->indeks_nagruzki])
            ->andFilterWhere(['like', 'indeks_skorosti', $this->indeks_skorosti])
            ->andFilterWhere(['like', 'uslilennaya_shina', $this->uslilennaya_shina])
            ->andFilterWhere(['like', 'ship_neship', $this->ship_neship])
            ->andFilterWhere(['like', 'postavshhik', $this->postavshhik])
            ->andFilterWhere(['like', 'gorod', $this->gorod])
            ->andFilterWhere(['like', 'fajjl_izobrazhenie', $this->fajjl_izobrazhenie]);

        return $dataProvider;
    }/**/
    
    public function getGridColumns(){
        $data = [];
     
       $data = [['class' => 'yii\grid\SerialColumn']];
      
       $data +=['id','id','tire_id','nazvanie',
       		['attribute'=>'tire','value'=>function($model){
           if (isset ($model->tire->title)){
           return $model->tire->title;}
           else{
        return;}
       			}],
       		['attribute'=> 'data_obnovleniya_sklada',
       			'value'=>function($model){
       				return date('d.m.Y H:i:s',$model->data_obnovleniya_sklada);
       			}
       		],
       		'optovaya_iskhodnaya_cena','vykhodnaya_roznichnaya_cena','ostatok'];
   /*     $attributes = $this->attributes();
        foreach ($attributes as $attribute){
              array_push($data,  ['attribute'=>$attribute]);
        }
    * 
    */
     // $data = ['brend','model'];
     array_push($data,['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}',
         'buttons'=>$this->getButtons()]);
        return $data;// 
       //      
    }/**/
    
    private function getButtons(){
        $buttons = [];
        $buttons['update'] = function ($url, $model) {
                   return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/supplier/update-ajax',
                               'supplier'=>'TireTrader','type'=>'Tires', 'id'=>$model['id']],
                            [
                                'class'          => 'ajaxUpdate',
                           //     'delete-url'     => $url,
                               
                                'data-toggle'=>'modal',
                                 'data-target'=>'#gallery-image-update-modal',
                                 'pjax-container' => 'pjaxSupplier',
                                'title'          => Yii::t('app', 'Update')
                            ]
                        );
                   };
         $buttons['delete'] = function ($url, $model) {
                    return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['/supplier/delete',
                          'supplier'=>'TireTrader','type'=>'Tires','id'=>$model['id'],
                                ],
                            [
                                'class'          => 'ajaxDelete',
                           //     'delete-url'     => $url,
                                'data-confirm'=>Yii::t('yii','Are you sure you want to delete this item?'),
                                'data-method'=>'post',
                                 'data-pjax'=>1,
                                 'pjax-container' => 'pjaxSupplier',
                                'title'          => Yii::t('app', 'Delete')
                            ]
                        );
                };           
                   
        return $buttons;
    }/**/
    
}/*end of Model*/
