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
use yii\data\Sort;


class ActividadesController extends controller
{
    
    // Muestra las actividades recomendadas
    public function actionRecomendadas()
    {
        $actividades = Actividad::find()->all();
        return $this->render('actividades_recomendadas', [
            'actividades' => $actividades
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
        $sort = new Sort([
            'attributes' => [
                'id',
                'titulo',
                'descripcion',
                'fecha_celebracion',
            ],
        ]);

        $query = Actividad::find()->orderBy($sort->orders);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('panel_administrador', [
            'id' => $countries,
            'pagination' => $pagination,
            'sort' => $sort,
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
        // Crea una nueva actividad
        public function actionCrear()
        {
            $model = new Actividad();
        
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Actividad creada exitosamente.');
                return $this->redirect(['ver_actividad', 'id' => $model->id]);

            }
        
            return $this->render('crear_actividad', [
                'model' => $model, // Pasa el modelo a la vista
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

    public function actionVer_participantes_actividad($id)
    {
        $db = Yii::$app->db;

        $model = $db->createCommand('SELECT * FROM USUARIO u JOIN PARTICIPA au ON u.id = au.USUARIOid WHERE au.ACTIVIDADid = :id')
            ->bindValue(':id', $id)
            ->queryAll();

         return $this->render('vista_participantes_actividad', [
             'participantes' => $model,
         ]);
    }

    public function actionVer_etiquetas_actividad($id)
    {
        $db = Yii::$app->db;

        $etiquetas = $db->createCommand('SELECT * FROM ETIQUETAS e JOIN ETIQUETAS_ACTIVIDAD ea on e.id=ea.ETIQUETASid WHERE ea.ACTIVIDADid= :id')
            ->bindValue(':id', $id)
            ->queryAll();

        return $this->render('vista_etiquetas_actividad', [
            'etiquetas' => $etiquetas,
            'id' => $id,
        ]);
    }


    
}