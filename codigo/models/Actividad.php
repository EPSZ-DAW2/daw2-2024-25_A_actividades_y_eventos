<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $descripcion
 * @property string|null $fecha_celebracion
 * @property string|null $duracion_estimada
 * @property string|null $lugar_celebracion
 * @property string|null $detalles
 * @property string|null $notas
 * @property resource|null $imagen_principal
 * @property string|null $edad_recomendada
 * @property int|null $etiquetas
 * @property string|null $estado_actividad
 * @property int|null $patrocinios_actividad
 * @property int|null $seguimientos
 * @property int|null $participacion
 * @property float|null $valoracion
 * @property int|null $comentarios
 * @property int|null $clasificacion
 * @property int|null $imagenes_adicionales
 * @property int|null $votosOK
 * @property int|null $votosKO
 * @property int|null $registro_usuario
 *
 * @property ClasificacionActividad $clasificacion0
 * @property Comentarios $comentarios0
 * @property Comentarios[] $comentarios1
 * @property EtiquetasActividad $etiquetas0
 * @property ImagenesActividad $imagenesAdicionales
 * @property Notificaciones[] $notificaciones
 * @property Participante[] $participantes
 * @property PatrociniosActividad $patrociniosActividad
 * @property PatrociniosActividad[] $patrociniosActividads
 * @property RegistroUsuario $registroUsuario
 * @property Seguimientos[] $seguimientos0
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'detalles', 'notas', 'imagen_principal'], 'string'],
            [['fecha_celebracion'], 'safe'],
            [['etiquetas', 'patrocinios_actividad', 'seguimientos', 'participacion', 'comentarios', 'clasificacion', 'imagenes_adicionales', 'votosOK', 'votosKO', 'registro_usuario'], 'integer'],
            [['valoracion'], 'number'],
            [['titulo', 'duracion_estimada', 'lugar_celebracion', 'edad_recomendada', 'estado_actividad'], 'string', 'max' => 500],
            [['clasificacion'], 'exist', 'skipOnError' => true, 'targetClass' => ClasificacionActividad::class, 'targetAttribute' => ['clasificacion' => 'id']],
            [['comentarios'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['comentarios' => 'id']],
            [['etiquetas'], 'exist', 'skipOnError' => true, 'targetClass' => EtiquetasActividad::class, 'targetAttribute' => ['etiquetas' => 'id']],
            [['imagenes_adicionales'], 'exist', 'skipOnError' => true, 'targetClass' => ImagenesActividad::class, 'targetAttribute' => ['imagenes_adicionales' => 'id']],
            [['patrocinios_actividad'], 'exist', 'skipOnError' => true, 'targetClass' => PatrociniosActividad::class, 'targetAttribute' => ['patrocinios_actividad' => 'id']],
            [['registro_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => RegistroUsuario::class, 'targetAttribute' => ['registro_usuario' => 'id']],
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
            'descripcion' => 'Descripcion',
            'fecha_celebracion' => 'Fecha Celebracion',
            'duracion_estimada' => 'Duracion Estimada',
            'lugar_celebracion' => 'Lugar Celebracion',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'imagen_principal' => 'Imagen Principal',
            'edad_recomendada' => 'Edad Recomendada',
            'etiquetas' => 'Etiquetas',
            'estado_actividad' => 'Estado Actividad',
            'patrocinios_actividad' => 'Patrocinios Actividad',
            'seguimientos' => 'Seguimientos',
            'participacion' => 'Participacion',
            'valoracion' => 'Valoracion',
            'comentarios' => 'Comentarios',
            'clasificacion' => 'Clasificacion',
            'imagenes_adicionales' => 'Imagenes Adicionales',
            'votosOK' => 'Votos Ok',
            'votosKO' => 'Votos Ko',
            'registro_usuario' => 'Registro Usuario',
        ];
    }

    /**
     * Gets query for [[Clasificacion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacion0()
    {
        return $this->hasOne(ClasificacionActividad::class, ['id' => 'clasificacion']);
    }

    /**
     * Gets query for [[Comentarios0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios0()
    {
        return $this->hasOne(Comentarios::class, ['id' => 'comentarios']);
    }

    /**
     * Gets query for [[Comentarios1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios1()
    {
        return $this->hasMany(Comentarios::class, ['actividad' => 'id']);
    }

    /**
     * Gets query for [[Etiquetas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetas0()
    {
        return $this->hasOne(EtiquetasActividad::class, ['id' => 'etiquetas']);
    }

    /**
     * Gets query for [[ImagenesAdicionales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesAdicionales()
    {
        return $this->hasOne(ImagenesActividad::class, ['id' => 'imagenes_adicionales']);
    }

    /**
     * Gets query for [[Notificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificaciones::class, ['actividad' => 'id']);
    }

    /**
     * Gets query for [[Participantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['actividad' => 'id']);
    }

    /**
     * Gets query for [[PatrociniosActividad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrociniosActividad()
    {
        return $this->hasOne(PatrociniosActividad::class, ['id' => 'patrocinios_actividad']);
    }

    /**
     * Gets query for [[PatrociniosActividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrociniosActividads()
    {
        return $this->hasMany(PatrociniosActividad::class, ['actividad' => 'id']);
    }

    /**
     * Gets query for [[RegistroUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegistroUsuario()
    {
        return $this->hasOne(RegistroUsuario::class, ['id' => 'registro_usuario']);
    }

    /**
     * Gets query for [[Seguimientos0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos0()
    {
        return $this->hasMany(Seguimientos::class, ['actividad' => 'id']);
    }
}
