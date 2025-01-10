<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentario_actividad".
 *
 * @property int $COMENTARIOid
 * @property int $ACTIVIDADid
 *
 * @property Actividad $aCTIVIDAD
 * @property Comentario $cOMENTARIO
 */
class ComentarioActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['COMENTARIOid', 'ACTIVIDADid'], 'required'],
            [['COMENTARIOid', 'ACTIVIDADid'], 'integer'],
            [['COMENTARIOid', 'ACTIVIDADid'], 'unique', 'targetAttribute' => ['COMENTARIOid', 'ACTIVIDADid']],
            [['COMENTARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['COMENTARIOid' => 'id']],
            [['ACTIVIDADid'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['ACTIVIDADid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'COMENTARIOid' => Yii::t('app', 'ID Comentario'),
            'ACTIVIDADid' => Yii::t('app', 'ID Actividad'),
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
     * Gets query for [[COMENTARIO]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCOMENTARIO()
    {
        return $this->hasOne(Comentario::class, ['id' => 'COMENTARIOid']);
    }
}
