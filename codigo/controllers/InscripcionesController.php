<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Inscripcion;
use app\models\Usuario;

class InscripcionesController extends Controller
{
    // Muestra las actividades a las que está inscrito un usuario
    public function actionMisActividades()
    {
        $usuarioId = Yii::$app->user->id; // Obtener el ID del usuario autenticado

        // Si no está autenticado, redirigir al login
        if (!$usuarioId) {
            return $this->redirect(['site/login']);
        }

        // Obtener las inscripciones del usuario actual
        $inscripciones = Inscripcion::find()
            ->where(['usuario_id' => $usuarioId])
            ->with('actividad') // Traer la relación con Actividad
            ->all();

        return $this->render('mis_actividades', [
            'inscripciones' => $inscripciones,
        ]);
    }
}
