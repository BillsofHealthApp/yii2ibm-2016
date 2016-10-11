<?php

namespace providend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use providend\models\ProviderControl;

/**
 * ProviderControlSearch represents the model behind the search form about `providend\models\ProviderControl`.
 */
class ProviderControlSearch extends ProviderControl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pcontrol_id', 'prov_id', 'login', 'profile', 'business', 'prices'], 'integer'],
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
        $query = ProviderControl::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('providers');
        
        // grid filtering conditions
        $query->andFilterWhere([
            'pcontrol_id' => $this->pcontrol_id,
            'prov_id' => $this->prov_id,
            'login' => $this->login,
            'profile' => $this->profile,
            'business' => $this->business,
            'prices' => $this->prices,
        ]);

        return $dataProvider;
    }
}
