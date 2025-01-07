<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Etiqueta;
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
}
