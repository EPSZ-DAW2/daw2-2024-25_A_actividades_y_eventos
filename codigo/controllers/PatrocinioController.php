<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Patrocinadores;
use app\models\PatrocinadoresForm;

class PatrocinioController extends Controller
{
    public function actionIndex()
    {
        $patrocinadores = (new Patrocinadores())->getPatrocinadores(); // Uso del método getPatrocinadores para obtener los patrocinadores
        return $this->render('index', [
            'patrocinadores' => $patrocinadores
        ]);
    }

    public function actionAdd()
    {
        $model = new PatrocinadoresForm();
        $title = "Añadir nuevo patrocinador";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $patrocinador = new Patrocinadores();
            $patrocinador->nick = $model->nick;
            $patrocinador->password = $model->password;
            $patrocinador->email = $model->email;
            $patrocinador->nombre = $model->nombre;
            $patrocinador->apellidos = $model->apellidos;
            $patrocinador->fecha_nacimiento = $model->fecha_nacimiento;
            $patrocinador->ubicacion = $model->ubicacion;
            $patrocinador->activo = $model->activo;
            $patrocinador->fecha_registro = $model->fecha_registro;
            $patrocinador->registro_confirmado = $model->registro_confirmado;
            $patrocinador->revisado = $model->revisado;
            $patrocinador->ultimo_acceso = $model->ultimo_acceso;
            $patrocinador->intentos_acceso = $model->intentos_acceso;
            $patrocinador->bloqueado = $model->bloqueado;
            $patrocinador->fecha_bloqueo = $model->fecha_bloqueo;
            $patrocinador->motivo_bloqueo = $model->motivo_bloqueo;
            $patrocinador->notas = $model->notas;
            $patrocinador->save(); // Guarda el nuevo patrocinador

            // Añadir el rol de patrocinador en la tabla roles
            Yii::$app->db->createCommand()->insert('roles', [
                'nombre_usuario' => $patrocinador->nick,
                'rol' => 'patrocinador',
            ])->execute();

            return $this->redirect(['index']); // Redirige a la página principal
        }

        return $this->render('formulario', [
            'title' => $title,
            'model' => $model
        ]);
    }


    public function actionEliminar($id)
    {
        $patrocinador = Patrocinadores::findOne($id);
        if ($patrocinador) {
            // Eliminar el rol de patrocinador en la tabla roles
            Yii::$app->db->createCommand()->delete('roles', ['nombre_usuario' => $patrocinador->nick])->execute();
            // Eliminar el patrocinador de la tabla usuario
            $patrocinador->delete();
        }

        return $this->redirect(['index']);
    }
}