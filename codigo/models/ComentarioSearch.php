<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comentario;

/**
 * ComentarioSearch represents the model behind the search form of `app\models\Comentario`.
 */
class ComentarioSearch extends Comentario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cerrado_comentario', 'numero_de_denuncias', 'USUARIOid', 'ACTIVIDADid'], 'integer'],
            [['texto', 'comentario_relacionado', 'fecha_bloque', 'motivos_bloqueo'], 'safe'],
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
        $query = Comentario::find();

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
            'cerrado_comentario' => $this->cerrado_comentario,
            'numero_de_denuncias' => $this->numero_de_denuncias,
            'fecha_bloque' => $this->fecha_bloque,
            'USUARIOid' => $this->USUARIOid,
            'ACTIVIDADid' => $this->ACTIVIDADid,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'comentario_relacionado', $this->comentario_relacionado])
            ->andFilterWhere(['like', 'motivos_bloqueo', $this->motivos_bloqueo]);

        return $dataProvider;
    }
}
