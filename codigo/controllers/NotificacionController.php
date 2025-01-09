<?php

namespace app\controllers;


use Yii;
use app\models\Notificacion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\RegistroAcciones;


class NotificacionController extends controller
{
    

    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Set de la fecha de lecturas si no está establecida
        if (!$model->fecha_lectura) {
            $model->fecha_lectura = date('Y-m-d H:i:s');
            $model->save(false);
            $this->logAction('leida', 'Notificación marcada como leída');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionMarcarLeida($id)
    {
        $model = $this->findModel($id);

        if (!$model->fecha_lectura) {
            $model->fecha_lectura = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Notificación marcada como leída.');
            } else {
                Yii::$app->session->setFlash('error', 'Error al marcar la notificación como leída.');
            }
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionAceptar($id)
    {
        $model = $this->findModel($id);

        if (!$model->fecha_aceptacion) {
            $model->fecha_aceptacion = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Notificación aceptada.');
                $this->logAction('aceptar', 'Notificación aceptada');
            } else {
                Yii::$app->session->setFlash('error', 'Error al aceptar la notificación.');
            }
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    // Acción personalizada para eliminar notificaciones
    public function actionEliminar($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);

        if (!$model->fecha_borrado) {
            $model->fecha_borrado = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                return ['status' => 'success', 'message' => 'Notificación eliminada.'];
            } else {
                return ['status' => 'error', 'message' => 'Error al eliminar la notificación.'];
            }
        }

        return ['status' => 'error', 'message' => 'La notificación ya está eliminada.'];
    }

    protected function findModel($id)
    {
        if (($model = Notificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La notificación solicitada no existe.');
    }

    protected function logAction($action, $details)
    {
        $log = new RegistroAcciones();
        $log->usuario_accion = Yii::$app->user->identity->nick;
        $log->fecha_accion = date('Y-m-d H:i:s');
        $log->accion = $details;
        $log->save();
    }
}
