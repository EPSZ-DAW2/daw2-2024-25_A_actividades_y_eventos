<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $cod_clase
 * @property string|null $texto
 * @property int|null $usuario_origen
 * @property int|null $usuario_destino
 * @property int|null $actividad
 * @property int|null $comentario
 * @property string|null $fecha_lectura
 * @property string|null $fecha_borrado
 * @property string|null $fecha_aceptacion
 *
 * @property Actividad $actividad0
 * @property Comentario $comentario0
 * @property Usuario $usuarioDestino
 * @property Usuario $usuarioOrigen
 */
class Notificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptacion'], 'safe'],
            [['texto'], 'string'],
            [['usuario_origen', 'usuario_destino', 'actividad', 'comentario'], 'integer'],
            [['cod_clase'], 'string', 'max' => 500],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
            [['comentario'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['comentario' => 'id']],
            [['usuario_destino'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_destino' => 'id']],
            [['usuario_origen'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_origen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'cod_clase' => Yii::t('app', 'Cod Clase'),
            'texto' => Yii::t('app', 'Texto'),
            'usuario_origen' => Yii::t('app', 'Usuario Origen'),
            'usuario_destino' => Yii::t('app', 'Usuario Destino'),
            'actividad' => Yii::t('app', 'Actividad'),
            'comentario' => Yii::t('app', 'Comentario'),
            'fecha_lectura' => Yii::t('app', 'Fecha Lectura'),
            'fecha_borrado' => Yii::t('app', 'Fecha Borrado'),
            'fecha_aceptacion' => Yii::t('app', 'Fecha Aceptacion'),
        ];
    }

    /**
     * Gets query for [[Actividad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::class, ['id' => 'actividad']);
    }

    /**
     * Gets query for [[Comentario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario0()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario']);
    }

    /**
     * Gets query for [[UsuarioDestino]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDestino()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_destino']);
    }

    /**
     * Gets query for [[UsuarioOrigen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioOrigen()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_origen']);
    }
}
