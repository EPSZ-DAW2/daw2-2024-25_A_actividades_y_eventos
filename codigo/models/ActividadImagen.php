<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagen_actividad".
 *
 * @property int $IMAGENid
 * @property int $ACTIVIDADid
 * @property int|null $orden
 *
 * @property Actividad $aCTIVIDAD
 * @property Imagen $iMAGEN
 */
class ActividadImagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IMAGENid', 'ACTIVIDADid'], 'required'],
            [['IMAGENid', 'ACTIVIDADid', 'orden'], 'integer'],
            [['IMAGENid', 'ACTIVIDADid'], 'unique', 'targetAttribute' => ['IMAGENid', 'ACTIVIDADid']],
            [['IMAGENid'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['IMAGENid' => 'id']],
            [['ACTIVIDADid'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['ACTIVIDADid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IMAGENid' => 'Image Nid',
            'ACTIVIDADid' => 'Activida Did',
            'orden' => 'Orden',
        ];
    }

    /**
     * Gets query for [[ACTIVIDAD]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getACTIVIDAD()
    {
        return $this->hasOne(Actividad::class, ['id' => 'ACTIVIDADid']);
    }

    /**
     * Gets query for [[IMAGEN]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIMAGEN()
    {
        return $this->hasOne(Imagen::class, ['id' => 'IMAGENid']);
    }

    public function setImagen($imagenId)
    {
        $this->IMAGENid = $imagenId;
        return $this->save(false);
    }
}
