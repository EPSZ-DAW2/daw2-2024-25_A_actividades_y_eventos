<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuario`.
 */
class UsuariosSearch extends Usuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'activo', 'registro_confirmado', 'revisado', 'intentos_acceso', 'bloqueado'], 'integer'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'fecha_nacimiento', 'direccion', 'ubicacion', 'ultimo_acceso', 'fecha_hora_bloqueo', 'motivo_bloqueo', 'notas'], 'safe'],
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
        $query = Usuario::find();

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'activo' => $this->activo,
            'registro_confirmado' => $this->registro_confirmado,
            'revisado' => $this->revisado,
            'ultimo_acceso' => $this->ultimo_acceso,
            'intentos_acceso' => $this->intentos_acceso,
            'bloqueado' => $this->bloqueado,
        ]);

        $query->andFilterWhere(['like', 'nick', $this->nick])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
            ->andFilterWhere(['like', 'motivo_bloqueo', $this->motivo_bloqueo])
            ->andFilterWhere(['like', 'notas', $this->notas]);

        return $dataProvider;
    }
}
