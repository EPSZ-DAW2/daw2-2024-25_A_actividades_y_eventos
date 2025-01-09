<?php
namespace app\components;

use Yii;
use yii\web\User as BaseUser;
use app\models\Usuario;

class User extends BaseUser
{

    /**
     * Metodo para ver si un usuario tiene un rol determinado
     * @param int|array $idRol El id del rol a comprobar o un array de ids
     * @return bool True si el usuario tiene alguno de los roles, false en caso contrario
     */
    public function hasRole($roleID)
    {
        // Obtén el ID del usuario actual
        $userID = Yii::$app->user->id;

        // Consulta la base de datos para verificar si el usuario tiene el rol
        // Creamos la consulta
        $query = (new \yii\db\Query())
            ->select('ROLESid')
            ->from('usuario_roles')
            ->where(['USUARIOid' => $userID])
            ->andWhere(['in', 'ROLESid', $roleID]);

        // devolvemos si el usuario tiene el rol
        return $query->exists();
    }


    public function getUsuario(){
        return Usuario::findOne(Yii::$app->user->id);
    }
}