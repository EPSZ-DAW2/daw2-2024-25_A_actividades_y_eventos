<?php
namespace app\components;

use Yii;
use yii\web\User as BaseUser;
use app\models\Usuario;

class User extends BaseUser
{

    /**
     * Metodo para ver si un usuario tiene un rol determinado
     * @param int $idRol El id del rol a comprobar
     * @return bool Si el usuario tiene el rol
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
            ->where(['USUARIOid' => $userID])->one();

        return $query && $query['ROLESid'] == $roleID;
    }


    // public function tieneRol($idRol){
    //     // Obtenemos el id del usuario conectado
    //     $idUsuario = Yii::$app->user->id;

        // // Creamos la consulta
        // $query = (new Query())
        //     ->select('ROLESid')
        //     ->from('usuario_roles')
        //     ->where(['USUARIOid' => $idUsuario]);
        
    //     // Ejecutamos la consulta
    //     $match = $query->one();

    //     // Comprobamos si el usuario tiene el rol
    //     return $match && $match['ROLESid'] == $idRol;
    // }

    public function getUsuario()
    {
        return Usuario::findOne(Yii::$app->user->id);
    }
}