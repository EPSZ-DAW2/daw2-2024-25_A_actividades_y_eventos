<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistroAcciones;

/**
 * RegistroAccionesSearch represents the model behind the search form of `app\models\RegistroAcciones`.
 */
class RegistroAccionesSearch extends RegistroAcciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['usuario_accion', 'fecha_accion', 'accion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = RegistroAcciones::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_accion' => $this->fecha_accion,
        ]);

        $query->andFilterWhere(['like', 'usuario_accion', $this->usuario_accion])
            ->andFilterWhere(['like', 'accion', $this->accion]);

        return $dataProvider;
    }
}
