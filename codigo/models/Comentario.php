<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id
 * @property string|null $texto
 * @property string|null $comentario_relacionado
 * @property int|null $cerrado_comentario
 * @property int|null $numero_de_denuncias
 * @property string|null $fecha_bloque
 * @property string|null $motivos_bloqueo
 * @property int $USUARIOid
 * @property int $ACTIVIDADid
 *
 * @property Actividad $aCTIVIDAD
 * @property Actividad[] $aCTIVIDADs
 * @property ComentarioActividad[] $comentarioActividads
 * @property ComentarioUsuario[] $comentarioUsuarios
 * @property Usuario $uSUARIO
 * @property Usuario[] $uSUARIOs
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto', 'USUARIOid', 'ACTIVIDADid'], 'required'],
            [['USUARIOid', 'ACTIVIDADid', 'cerrado_comentario', 'numero_de_denuncias'], 'integer'],
            [['comentario_relacionado'], 'integer', 'skipOnEmpty' => true],
            [['fecha_bloque'], 'safe'],
            [['texto', 'motivos_bloqueo'], 'string', 'max' => 255],
            [['USUARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid' => 'id']],
            [['ACTIVIDADid'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['ACTIVIDADid' => 'id']],
            [['comentario_relacionado'], 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['comentario_relacionado' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto',
            'comentario_relacionado' => 'Comentario Relacionado',
            'cerrado_comentario' => 'Cerrado',
            'numero_de_denuncias' => 'Número de Denuncias',
            'fecha_bloque' => 'Fecha de Bloqueo',
            'motivos_bloqueo' => 'Motivos de Bloqueo',
            'USUARIOid' => 'Usuario',
            'ACTIVIDADid' => 'Actividad',
        ];
    }

    /**
     * Gets query for [[ACTIVIDAD]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getACTIVIDAD()
    {
        return $this->hasOne(Actividad::class, ['id' => 'ACTIVIDADid']);
    }

    /**
     * Gets query for [[ACTIVIDADs]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getACTIVIDADs()
    {
        return $this->hasMany(Actividad::class, ['id' => 'ACTIVIDADid'])->viaTable('comentario_actividad', ['COMENTARIOid' => 'id']);
    }

    /**
     * Gets query for [[ComentarioActividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarioActividads()
    {
        return $this->hasMany(ComentarioActividad::class, ['COMENTARIOid' => 'id']);
    }

    /**
     * Gets query for [[ComentarioUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarioUsuarios()
    {
        return $this->hasMany(ComentarioUsuario::class, ['COMENTARIOid' => 'id']);
    }

    /**
     * Gets query for [[USUARIO]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUSUARIO()
    {
        return $this->hasOne(Usuario::class, ['id' => 'USUARIOid']);
    }

    /**
     * Gets query for [[USUARIOs]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUSUARIOs()
    {
        return $this->hasMany(Usuario::class, ['id' => 'USUARIOid'])->viaTable('comentario_usuario', ['COMENTARIOid' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ComentarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComentarioQuery(get_called_class());
    }
}
