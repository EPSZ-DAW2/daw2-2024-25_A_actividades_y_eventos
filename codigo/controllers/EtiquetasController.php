<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Etiqueta;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EtiquetasController extends Controller
{
    // Lista todas las etiquetas
    public function actionIndex()
    {
        $etiquetas = Etiqueta::find()->all();
        return $this->render('index', [
            'etiquetas' => $etiquetas
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
