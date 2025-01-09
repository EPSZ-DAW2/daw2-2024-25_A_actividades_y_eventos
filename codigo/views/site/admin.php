<?php 
    use yii\helpers\Html;
    use app\components\User;
    use app\models\Roles;


    $this->title = 'Administracion';

?>
    <h2>Hola, <?= Yii::$app->user->identity->nick ?> !</h2>

    <p>
        Bienvenido al panel de administración de la aplicación. Como administrador que eres, 
        puedes gestionar las actividades, etiquetas, roles y usuarios de la aplicación.

    </p>
    
    <p>
        <?= Html::a('Gestion de actividades', ['actividades/administrador'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de etiquetas', ['etiquetas/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de roles', ['rol/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de usuarios', ['usuario/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Registro de actividades- LOG', ['registro-acciones/index'], ['class' => 'btn btn-success']); ?>
        
        <?php
        if (Yii::$app->user->hasRole(Roles::SYSADMIN)) {
            echo '<br><br>';
            echo '<p>Acciones de SysAdmin:</p>';
            echo Html::a('Gestion del servidor', ['parametros-servidor/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']);
            echo Html::a('Copia de seguridad', ['backup/index'], ['class' => 'btn btn-success', 'style' => 'margin-left: 10px;']);
        }
        ?>
    </p>