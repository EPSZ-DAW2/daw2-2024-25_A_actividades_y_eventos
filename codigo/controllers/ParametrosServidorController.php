<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\ParametrosServidor;
use app\models\Roles;

/**
 * Controlador para gestionar los parámetros del servidor
 */
class ParametrosServidorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->hasRole([Roles::SYSADMIN]);
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ParametrosServidor();
        $model->upload_max_filesize = ini_get('upload_max_filesize');
        $model->memory_limit = ini_get('memory_limit');

        if ($model->load(Yii::$app->request->post()) && $model->updatePhpSettings()) {
            Yii::$app->session->setFlash('success', 'Configuración actualizada correctamente');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
            'serverInfo' => ParametrosServidor::getServerInfo(),
        ]);
    }
}
