<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anuncio".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $texto
 * @property int|null $registro_de_usuario
 * @property string|null $notas
 *
 * @property Actividad[] $aCTIVIDADs
 * @property AnuncioActividad[] $anuncioActividads
 * @property Patrocina[] $patrocinas
 * @property Usuario[] $uSUARIOs
 */
class Anuncio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anuncio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registro_de_usuario'], 'integer'],
            [['titulo', 'texto', 'notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'texto' => 'Texto',
            'registro_de_usuario' => 'Registro De Usuario',
            'notas' => 'Notas',
        ];
    }

    /**
     * Gets query for [[ACTIVIDADs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getACTIVIDADs()
    {
        return $this->hasMany(Actividad::class, ['id' => 'ACTIVIDADid'])->viaTable('anuncio_actividad', ['ANUNCIOid' => 'id']);
    }

    /**
     * Gets query for [[AnuncioActividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncioActividads()
    {
        return $this->hasMany(AnuncioActividad::class, ['ANUNCIOid' => 'id']);
    }

    /**
     * Gets query for [[Patrocinas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrocinas()
    {
        return $this->hasMany(Patrocina::class, ['ANUNCIOid' => 'id']);
    }

    /**
     * Gets query for [[USUARIOs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUSUARIOs()
    {
        return $this->hasMany(Usuario::class, ['id' => 'USUARIOid'])->viaTable('patrocina', ['ANUNCIOid' => 'id']);
    }
}
