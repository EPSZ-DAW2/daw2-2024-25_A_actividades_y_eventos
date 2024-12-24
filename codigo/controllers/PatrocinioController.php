<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Patrocinadores;


class PatrocinioController extends Controller {
    public $layout = "//layouts/plantilla";
    
        
    public function actionIndex()
    {
        $patrocinadores = Patrocinadores::find()->all(); // Uso de ActiveRecord para obtener los patrocinadores
        return $this->render('index', [
            'patrocinadores' => $patrocinadores
        ]);
    } // actionIndex
    
    public function actionAdd()
    {
        $model = new PatrocinadoresForm();
        $title = "Añadir nuevos patrocinadores";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $patrocinador = new Patrocinadores();
            $patrocinador->nombre = $model->nombre;
            $patrocinador->apellido = $model->apellido;
            $patrocinador->email = $model->email;
            $patrocinador->password = $model->password;
            $patrocinador->save(); // Guarda el nuevo patrocinador

            return $this->redirect(['index']); // Redirige a la página principal
        }

        return $this->render('form', [
            'title' => $title,
            'model' => $model
        ]);
    } // actionAdd
    
    public function actionModificar($id)
    {
        $patrocinador = Patrocinadores::findOne($id);

        if (!$patrocinador) {
            throw new \yii\web\NotFoundHttpException('Patrocinador no encontrado');
        }

        $model = new PatrocinadoresForm();
        $model->setAttributes($patrocinador->attributes); // Establece los datos actuales del patrocinador

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $patrocinador->nombre = $model->nombre;
            $patrocinador->apellido = $model->apellido;
            $patrocinador->email = $model->email;
            $patrocinador->password = $model->password;
            $patrocinador->save(); // Guarda los cambios

            return $this->redirect(['index']); // Redirige a la página principal
        }

        return $this->render('form', [
            'title' => "Editar Patrocinador " . $id,
            'model' => $model,
            'patrocinador' => $patrocinador
        ]);
    } // actionModificar
    
    public function actionEliminar($id)
    {
        $patrocinador = Patrocinadores::findOne($id);
        if ($patrocinador) {
            $patrocinador->delete(); // Elimina el patrocinador
        }

        return $this->redirect(['index']); // Redirige a la página principal
    } // actionEliminar
}

