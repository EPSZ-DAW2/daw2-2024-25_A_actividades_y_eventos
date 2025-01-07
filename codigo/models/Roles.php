<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "roles".
 *
 * @property bigint $id
 * @property string|null $nombre_rol
 * @property string|null $descripcion
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
            'id' => 'ID',
            'nombre_rol' => 'Nombre Rol',
            'descripcion' => 'Descripción',
        ];
    }

    /**
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
