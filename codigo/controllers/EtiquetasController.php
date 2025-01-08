<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\Etiqueta;
use app\models\Actividad;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\Sort;

class EtiquetasController extends Controller
{
    // Lista todas las etiquetas
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'id',
                'Nombre',
                'Descripcion',
            ],
        ]);

        $query = Etiqueta::find()->orderBy($sort->orders);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $etiquetas = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'etiquetas' => $etiquetas,
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }

    // Muestra una etiqueta específica
    public function actionView($id)
    {
        $etiqueta = $this->findModel($id);
        return $this->render('view', [
            'etiqueta' => $etiqueta,
        ]);
    }

    // Crea una nueva etiqueta
    public function actionCreate()
    {
        $model = new Etiqueta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Etiqueta creada exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Actualiza una etiqueta existente
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Etiqueta actualizada exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Elimina una etiqueta
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Etiqueta eliminada exitosamente.');
        return $this->redirect(['index']);
    }

    // Encuentra el modelo de la etiqueta por ID
    protected function findModel($id)
    {
        if (($model = Etiqueta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La etiqueta solicitada no existe.');
        }
    }

    public function actionAsignar_etiqueta($actividad_id)
    {
        $model = new \yii\base\DynamicModel(['actividad_id', 'etiqueta_id']);
        $model->addRule(['actividad_id', 'etiqueta_id'], 'required')
              ->addRule(['actividad_id', 'etiqueta_id'], 'integer');

        // Obtener etiquetas de la base de datos
        $etiquetas = Etiqueta::find()->all();
        $listaEtiquetas = ArrayHelper::map($etiquetas, 'id', 'nombre');

        // Obtener actividades de la base de datos
        $actividades = Actividad::find()->all();
        $listaActividades = ArrayHelper::map($actividades, 'id', 'titulo'); 

        return $this->render('/actividades/vista_asignar_etiquetas_actividad', [
            'model' => $model,
            'listaEtiquetas' => $listaEtiquetas,
            'listaActividades' => $listaActividades,
        ]);
    }

    public function actionProcesar_asignacion_etiquetas()
    {
        $db = Yii::$app->db;

        $actividad = Yii::$app->request->post('DynamicModel')['actividad_id'];
        $etiqueta = Yii::$app->request->post('DynamicModel')['etiqueta_id'];

        if ($actividad !== null && $etiqueta !== null) {
            $db->createCommand('INSERT INTO `ETIQUETAS_ACTIVIDAD`(`ETIQUETASid`, `ACTIVIDADid`) VALUES (:etiqueta,:actividad)')
                ->bindValue(':actividad', $actividad)
                ->bindValue(':etiqueta', $etiqueta)
                ->execute();

            Yii::$app->session->setFlash('success', 'Etiqueta asignada exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Datos inválidos. Por favor, seleccione un actividad y una etiqueta.');
        }

        return $this->redirect(['actividades/administrador']);
    }

    public function actionEliminar_etiqueta_actividad($actividad_id, $etiqueta_id)
    {
        $db = Yii::$app->db;

        $db->createCommand('DELETE FROM `ETIQUETAS_ACTIVIDAD` WHERE `ETIQUETASid` = :etiqueta AND `ACTIVIDADid` = :actividad')
            ->bindValue(':actividad', $actividad_id)
            ->bindValue(':etiqueta', $etiqueta_id)
            ->execute();

        Yii::$app->session->setFlash('success', 'Etiqueta eliminada de la actividad exitosamente.');

        return $this->redirect(['actividades/administrador']);
    }
}
