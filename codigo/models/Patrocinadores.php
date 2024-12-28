<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Patrocinadores extends ActiveRecord
{
    public static function tableName()
    {
        return 'usuario'; // nombre de la tabla en la base de datos
    }

    // Método para conseguir todos los patrocinadores
    public function getPatrocinadores()
    {
        return self::find()
            ->innerJoin('roles', 'roles.nombre_usuario = usuario.nick')
            ->where(['roles.rol' => 'patrocinador'])
            ->all(); // Recupera todos los patrocinadores
    }

    // Método para conseguir un solo usuario
    public function getUnPatrocinador($id)
    {
        return self::find()
            ->innerJoin('roles', 'roles.nombre_usuario = usuario.nick')
            ->where(['usuario.id' => $id, 'roles.rol' => 'patrocinador'])
            ->one(); // Recupera un patrocinador específico por ID
    }

    // Método para eliminar patrocinadores
    public function eliminar($id)
    {
        $patrocinador = self::findOne($id);
        if ($patrocinador) {
            // Eliminar el rol de patrocinador en la tabla roles
            Yii::$app->db->createCommand()->delete('roles', ['nombre_usuario' => $patrocinador->nick])->execute();
            // Eliminar el patrocinador de la tabla usuario
            return $patrocinador->delete();
        }
        return false;
    }

    // Método para añadir usuarios
    public function add($nick, $password, $email, $nombre, $apellidos, $fecha_nacimiento, $ubicacion, $activo, $fecha_registro, $registro_confirmado, $revisado, $ultimo_acceso, $intentos_acceso, $bloqueado, $fecha_bloqueo, $motivo_bloqueo, $notas)
    {
        $patrocinador = new self();
        $patrocinador->nick = $nick;
        $patrocinador->password = $password;
        $patrocinador->email = $email;
        $patrocinador->nombre = $nombre;
        $patrocinador->apellidos = $apellidos;
        $patrocinador->fecha_nacimiento = $fecha_nacimiento;
        $patrocinador->ubicacion = $ubicacion;
        $patrocinador->activo = $activo;
        $patrocinador->fecha_registro = $fecha_registro;
        $patrocinador->registro_confirmado = $registro_confirmado;
        $patrocinador->revisado = $revisado;
        $patrocinador->ultimo_acceso = $ultimo_acceso;
        $patrocinador->intentos_acceso = $intentos_acceso;
        $patrocinador->bloqueado = $bloqueado;
        $patrocinador->fecha_bloqueo = $fecha_bloqueo;
        $patrocinador->motivo_bloqueo = $motivo_bloqueo;
        $patrocinador->notas = $notas;
        return $patrocinador->save();
    }

    
}