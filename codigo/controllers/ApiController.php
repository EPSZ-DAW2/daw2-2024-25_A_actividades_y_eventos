<?php
namespace app\controllers;
use yii\filters\auth\HttpBasicAuth;
use Yii;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use app\models\Usuario;
use yii\web\Response;
use app\models\Actividad;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\Actividad';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Configuración de CORS
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // Configuración de verbos HTTP permitidos
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = Usuario::findByNick($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
                return null;
            },
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Deshabilitar acciones predeterminadas
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);

        // Acciones personalizadas para Actividad
        $actions['actividad-index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => 'app\models\Actividad',
        ];
        $actions['actividad-view'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => 'app\models\Actividad',
        ];
        $actions['actividad-create'] = [
            'class' => 'yii\rest\CreateAction',
            'modelClass' => 'app\models\Actividad',
        ];
        $actions['actividad-update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => 'app\models\Actividad',
        ];
        $actions['actividad-delete'] = [
            'class' => 'yii\rest\DeleteAction',
            'modelClass' => 'app\models\Actividad',
        ];

        // Acciones personalizadas para Notificacion
        $actions['notificacion-index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => 'app\models\Notificacion',
        ];
        $actions['notificacion-view'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => 'app\models\Notificacion',
        ];
        $actions['notificacion-create'] = [
            'class' => 'yii\rest\CreateAction',
            'modelClass' => 'app\models\Notificacion',
        ];
        $actions['notificacion-update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => 'app\models\Notificacion',
        ];
        $actions['notificacion-delete'] = [
            'class' => 'yii\rest\DeleteAction',
            'modelClass' => 'app\models\Notificacion',
        ];

        return $actions;
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Actividad::findOne($id);
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $model;
        }
        return ['errors' => $model->errors];
    }
}