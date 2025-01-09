<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ubicacion;

/**
 * UbicacionSearch represents the model behind the search form of `app\models\Ubicacion`.
 */
class UbicacionSearch extends Ubicacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'clase_de_ubicacion'], 'integer'],
            [['ubicacion_raiz', 'notas', 'direccion', 'notas_de_como_llegar', 'notas_de_donde_aparcar'], 'safe'],
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
        $query = Ubicacion::find();

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
            'clase_de_ubicacion' => $this->clase_de_ubicacion,
        ]);

        $query->andFilterWhere(['like', 'ubicacion_raiz', $this->ubicacion_raiz])
            ->andFilterWhere(['like', 'notas', $this->notas])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'notas_de_como_llegar', $this->notas_de_como_llegar])
            ->andFilterWhere(['like', 'notas_de_donde_aparcar', $this->notas_de_donde_aparcar]);

        return $dataProvider;
    }
}
