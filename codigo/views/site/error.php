<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        El error anterior ocurrió mientras el servidor web procesaba su solicitud.
    </p>
    <p>
        Por favor contáctenos si cree que esto es un error del servidor. Gracias.
    </p>

</div>
