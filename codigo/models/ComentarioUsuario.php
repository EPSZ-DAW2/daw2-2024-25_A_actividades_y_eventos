<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentario_usuario".
 *
 * @property int $COMENTARIOid
 * @property int $USUARIOid
 *
 * @property Comentario $cOMENTARIO
 * @property Usuario $uSUARIO
 */
class ComentarioUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['COMENTARIOid', 'USUARIOid'], 'required'],
            [['COMENTARIOid', 'USUARIOid'], 'integer'],
            [['COMENTARIOid', 'USUARIOid'], 'unique', 'targetAttribute' => ['COMENTARIOid', 'USUARIOid']],
            [['COMENTARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['COMENTARIOid' => 'id']],
            [['USUARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'COMENTARIOid' => Yii::t('app', 'Id Comentario'),
            'USUARIOid' => Yii::t('app', 'Usuario relacionado'),
        ];
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

    /**
     * Gets query for [[USUARIO]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUSUARIO()
    {
        return $this->hasOne(Usuario::class, ['id' => 'USUARIOid']);
    }
}
