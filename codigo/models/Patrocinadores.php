<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Patrocinadores extends ActiveRecord{
    private $conexion;
    private $getPatrocinios;
    private $getUnPatrocinio;
   
    public static function tableName()
    {
        return 'Patrocinadores'; // nombre de la tabla en la base de datos
    } // tableName
    
     
    //Método para conseguir todos los patrocinadores
    public function getPatrocinadores(){
        return self::find()->all(); // Recupera todos los patrocinadores
    }//getPatrocinadores
     
    //Método para conseguir un solo usuario
    public function getUnPatrocinador($id){
        return self::findOne($id); // Recupera un patrocinador específico por ID
    }//getUnPatrocinador
     

    //Método para eliminar patrocinadores
    public function eliminar($id){
        $delete=$this->conexion->createCommand()->
        delete("Patrocinadores", "id=$id");
        return $delete;
    }//eliminar
     
    //Método para añadir patrocinadores
    public function add($nombre,$apellido,$email,$password){
        $insert=$this->conexion->createCommand()->
                insert("Patrocinadores",array(
                   "nombre"=>$nombre,
                   "apellido"=>$apellido,
                   "email"=>$email,
                   "password"=>$password
                ));
        return $insert;
    }//add
     
    //Método para modificar patrocinadores
    public function modidicar($id,$nombre,$apellido,$email,$password){
        $update=$this->conexion->createCommand()->
                update("Patrocinadores",array(
                   "nombre"=>$nombre,
                   "apellido"=>$apellido,
                   "email"=>$email,
                   "password"=>$password
                ),"id=$id");
        return $update;
    }//modificar
  
}//Patrocinadores
?>

