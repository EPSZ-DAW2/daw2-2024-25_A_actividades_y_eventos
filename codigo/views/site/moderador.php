<?php 
    use yii\helpers\Html;
    use app\components\User;
    use app\models\Roles;


    $this->title = 'Vista moderador';
?>

<h2>Hola, <?= Yii::$app->user->identity->nick ?> !</h2>

<p>
    Bienvenido al panel de moderación de la aplicación. Como moderador que eres, 
    puedes gestionar las actividades y comentarios de la aplicación.
</p>

<p>
    <?= Html::a('Gestion de actividades', ['actividades/administrador'], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Gestion de comentarios', ['comentarios/index'], ['class' => 'btn btn-success']); ?>
</p>