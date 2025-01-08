<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string|null $nombre_rol
 * @property string|null $descripcion
 * @property string|null $nombre_rol
 * @property string|null $descripcion
 *
 */
class Roles extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre_rol', 'descripcion'], 'string'],
            [['nombre_rol', 'descripcion'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre_rol' => Yii::t('app', 'Nombre Rol'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'nombre_rol' => Yii::t('app', 'Nombre Rol'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[ID]].
     */
    public function getID(){
        return $this->hasOne(Usuario::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Nombre_rol]].
     */
    public function getNombre_rol(){
        return $this->hasMany(Usuario::class, ['nombre_rol' => 'nick']);
    }

    /**
     * Gets query for [[Nombre_rol]].
     * Returns an array of role options.
     * @return array
     */
    public function getRoleOptions()
    {
        $roles = self::find()->all();
        $roleOptions = [];
        foreach ($roles as $role) {
            $roleOptions[$role->id] = $role->nombre_rol;
        }
        return $roleOptions;
    }
}
