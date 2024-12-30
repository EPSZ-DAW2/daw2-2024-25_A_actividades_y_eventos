<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Actividad;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActividadesController extends Controller
{
    // Muestra las actividades recomendadas
    public function actionRecomendadas()
    {
        $actividades = Actividad::find()->all();
        return $this->render('actividades_recomendadas', [
            'actividades' => $actividades
        ]);
    }

    // Crea una nueva actividad
    public function actionCreate()
    {
        $model = new Actividad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actividad creada exitosamente.');
            return $this->redirect(['recomendadas']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Actualiza una actividad existente
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actividad actualizada exitosamente.');
            return $this->redirect(['recomendadas']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Elimina una actividad
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Actividad eliminada exitosamente.');
        return $this->redirect(['recomendadas']);
    }

    // Visualiza los detalles de una actividad
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Encuentra el modelo de la actividad por ID
    protected function findModel($id)
    {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La actividad solicitada no existe.');
        }
    }

    // Para manejar validación AJAX en el formulario de creación y actualización
    public function actionValidate()
    {
        $model = new Actividad();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return null;
    }
}