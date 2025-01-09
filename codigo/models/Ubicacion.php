<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ubicacion".
 *
 * @property int $id
 * @property int|null $clase_de_ubicacion
 * @property string|null $ubicacion_raiz
 * @property string|null $notas
 * @property string|null $direccion
 * @property string|null $notas_de_como_llegar
 * @property string|null $notas_de_donde_aparcar
 *
 * @property Actividad[] $aCTIVIDADs
 * @property ActividadUbicacion[] $actividadUbicacions
 * @property Usuario[] $uSUARIOs
 * @property UsuarioUbicacion[] $usuarioUbicacions
 */
class Ubicacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ubicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clase_de_ubicacion'], 'integer'],
            [['ubicacion_raiz', 'notas', 'direccion', 'notas_de_como_llegar', 'notas_de_donde_aparcar'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clase_de_ubicacion' => 'Clase De Ubicacion',
            'ubicacion_raiz' => 'Ubicacion Raiz',
            'notas' => 'Notas',
            'direccion' => 'Direccion',
            'notas_de_como_llegar' => 'Notas De Como Llegar',
            'notas_de_donde_aparcar' => 'Notas De Donde Aparcar',
        ];
    }

    /**
     * Gets query for [[ACTIVIDADs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getACTIVIDADs()
    {
        return $this->hasMany(Actividad::class, ['id' => 'ACTIVIDADid'])->viaTable('actividad_ubicacion', ['UBICACIONid' => 'id']);
    }

    /**
     * Gets query for [[ActividadUbicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividadUbicacions()
    {
        return $this->hasMany(ActividadUbicacion::class, ['UBICACIONid' => 'id']);
    }

    /**
     * Gets query for [[USUARIOs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUSUARIOs()
    {
        return $this->hasMany(Usuario::class, ['id' => 'USUARIOid'])->viaTable('usuario_ubicacion', ['UBICACIONid' => 'id']);
    }

    /**
     * Gets query for [[UsuarioUbicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioUbicacions()
    {
        return $this->hasMany(UsuarioUbicacion::class, ['UBICACIONid' => 'id']);
    }
}
