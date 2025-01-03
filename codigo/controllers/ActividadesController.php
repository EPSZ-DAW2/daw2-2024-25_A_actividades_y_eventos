<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Actividad;
use app\models\Clasificacion;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\Pagination;

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
    public function actionCrear()
    {
        $model = new Actividad();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Actividad creada exitosamente.');
                return $this->redirect(['actividades/administrador']);
            } else {
                // Depurar errores de validación
                var_dump($model->errors);
                die();
            }
        }

        return $this->render('crear_actividad', [
            'model' => $model,
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



    public function actionAdministrador()
    {
        $query = Actividad::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('panel_administrador', [
            'id' => $countries,
            'pagination' => $pagination,
        ]);
    }

    public function actionVer_actividad($id)
    {
        $model = Actividad::findOne($id);
        return $this->render('ver_actividad', [
            'model' => $model,
        ]);
    }

    // Acción para editar una actividad
    public function actionEditar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actividad actualizada exitosamente.');
            return $this->redirect(['ver_actividad', 'id' => $model->id]);
        }

        return $this->render('editar_actividad', [
            'model' => $model,
        ]);
    }
    
    // Elimina una actividad
    public function actionEliminar($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Actividad eliminada exitosamente.');
        return $this->redirect(['actividades/administrador']);
    }


    
}