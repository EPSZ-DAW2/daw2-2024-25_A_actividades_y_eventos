<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Editar Perfil';
?>
<div class="usuario-editar-perfil">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'newEmail')->textInput(['maxlength' => true])->label('Nuevo Email') ?>
        <?= $form->field($model, 'confirmNewEmail')->textInput(['maxlength' => true])->label('Confirmar nuevo Email') ?>

        <hr>

        <?= $form->field($model, 'currentPassword')->passwordInput()->label('Contraseña actual')?>
        <?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva contraseña')?>
        <?= $form->field($model, 'confirmNewPassword')->passwordInput()->label('Confirmar nueva contraseña')?>
        

        <div class="form-group mt-2">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['mi-perfil'], ['class' => 'btn btn-danger', 'name'=>'submit-button', 'value'=>'cambiarAll']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <br>
</div>

<div class = "d-none">
        <?php
            // API Key de Google Maps
            $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
            $direccionActividad = "plaza marina 1, 49004 Zamora";
            $direccionEncodedActividad = urlencode($direccionActividad);
            $urlActividad = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedActividad&components=country:ES&key=$apiKey";
            $responseActividad = file_get_contents($urlActividad);
            $dataActividad = json_decode($responseActividad, true);

            if ($dataActividad['status'] == 'OK') {
                $latActividad = $dataActividad['results'][0]['geometry']['location']['lat'];
                $lngActividad = $dataActividad['results'][0]['geometry']['location']['lng'];
            } else {
                $latActividad = null;
                $lngActividad = null;
            }

            $this->params['latActividad'] = $latActividad;
            $this->params['lngActividad'] = $lngActividad;


            // Agregar mapa de actividad
            if ($latActividad && $lngActividad) {
                echo "<div style='display: flex; justify-content: center; align-items: center;'>
                    <div id='map-actividad' style='width: 100%; height: 200px;'></div>
                </div>";
            }
        ?>
    </div>