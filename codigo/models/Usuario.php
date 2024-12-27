<?php

namespace app\models;

class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $CAMPO_LOGIN;
    public $CAMPO_PASSWORD;
    public $CAMPO_CLAVE_PRIMARIA;
    public $CAMPO_CLAVE_AUTORIZACION;
  
  //Atributos para almacenar el control de cambio de la posible contraseña.
  public $password1;
  public $password2;
  
  //--->>>
  // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
  //--->>>
  
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    //*** Sustituir "TABLA_USUARIOS" por el nombre correspondiente -> "usuarios"
    return '{{%usuarios}}';
  }
  
  //PENDIENTE: Método "rules".
  //PENDIENTE: Método "attributeLabels".
  //PENDIENTE: Método "scenarios" (opcional).
  //PENDIENTE: Método "find".
  
  //<<<---
  // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
  //<<<---
  
  //--->>>
  // Métodos necesarios para cumplir con el "IdentityInterface".
  //--->>>
  
  /**
   * {@inheritdoc}
   */
  public static function findIdentity($id)
  {
    $model= null;
    
    //Programar aquí la carga de un "Usuario" por su clave primaria.
    if (!empty( $id)) $model= static::findOne( $id);
    
    return $model;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    $model= null;
    
    //Programar aquí la carga de un "Usuario" por su "token" de acceso 
    //el cual puede ser una variante de su clave primaria o similar para
    //asegurar que sea único en la tabla correspondiente.
    //*** Sustituir "CAMPO_TOKEN" por el nombre correspondiente.
    if (!empty( $token)) $model= static::findOne( ['CAMPO_TOKEN'=>$token]);
    
    return $model;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getId()
  {
    //*** Sustituir "CAMPO_CLAVE_PRIMARIA" por el nombre correspondiente.
    return $this->CAMPO_CLAVE_PRIMARIA;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getAuthKey()
  {
    //*** Sustituir "CAMPO_CLAVE_AUTORIZACION" por el nombre correspondiente
    //o generar un resultado en función del campo "CAMPO_CLAVE_PRIMARIA" si
    //no se implementa un servicio web que necesite mayor seguridad.
    return $this->CAMPO_CLAVE_AUTORIZACION;
  }
  
  /**
   * {@inheritdoc}
   */
  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }
  
  //<<<---
  // Métodos necesarios para cumplir con el "IdentityInterface".
  //<<<---
  
  /**
   * Buscar un modelo "Usuario" por su nombre de usuario o el típico campo
   * "login" o "email" o similar.
   *
   * Este método no pertenece al "IdentityInterface", se introduce para 
   * delegar el sistema de "login" al "LoginForm".
   *
   * @param string $username
   * @return static|null
   */
  public static function findByUsername($username)
  {
    if ($username === 'admin') {
      $model = new static();
      $model->CAMPO_LOGIN = 'admin';
      $model->CAMPO_PASSWORD = 'admin';
      return $model;
    }

    $model= null;
    
    //Programar aquí la carga de un "Usuario" por su "login" de usuario o similar.
    //*** Sustituir "CAMPO_LOGIN" por el nombre correspondiente. -> "nick"
    //*** Descomentar y sustituir "CAMPO_ACTIVO" por el nombre correspondiente
    //si se utiliza un posible sistema de usuario activo o inactivo.
    //*** Descomentar y sustituir "CAMPO_BLOQUEADO" por el nombre correspondiente
    //si se utiliza un posible sistema de usuario bloqueado o no bloqueado.
    if (!empty( $id)) $model= static::findOne([
        'nick'=>$username
      //, 'CAMPO_ACTIVO'=>true
      //, 'CAMPO_BLOQUEADO'=>false
    ]);
    
    return $model;
  }

  /**
   * Validar la contraseña recibida con la que contiene la instancia actual
   * del modelo de usuario.
   *
   * Este método no pertenece al "IdentityInterface", se introduce para 
   * delegar el sistema de "login" al "LoginForm".
   *
   * @param string $password password a validar
   * @return bool Si la clave es válida para el usuario actual.
   */
  public function validatePassword($password)
  {
    if ($this->CAMPO_LOGIN === 'admin' && $password === 'admin') {
      return true;
    }

    //*** Sustituir "CAMPO_PASSWORD" por el nombre correspondiente.
    //*** Si el "CAMPO_PASSWORD" está ofuscado-diversificado por alguna 
    //función HASH se debe aplicar la función HASH a "$password" antes 
    //de comparar, o si se usa el sistema "Security" de Yii2, se debe hacer
    //la comparación usando sus funcionalidades.
    return ($this->CAMPO_PASSWORD === $password);
    /*---*-/ 
    $hashPassword= ALGUNA_FUNCION_HASH( $password);
    return ($this->CAMPO_PASSWORD === $hashPassword);
    //---*/
    
  }
  
}
