<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use app\models\Notificacion;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['editar-perfil', 'mi-perfil'],
                'rules' => [
                    // Permitir a los usuarios autenticados acceder a su perfil y editarlo
                    [
                        'actions' => ['mi-perfil', 'editar-perfil'],
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
                ]
            ]
        );
    }

    /**
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionMiPerfil()
    {
        $model = Yii::$app->user->identity;

        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }

        // Escenario para cambiar contraseña
        $model->setScenario('changePassword');

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'La contraseña se cambió correctamente.');
            return $this->refresh();
        }

        return $this->render('mi-perfil', [
            'model' => $model,
        ]);
    }

    public function actionEditarPerfil()
    {
        // Obtener el modelo del usuario autenticado
        $model = Yii::$app->user->identity;
    
        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }
    
        // Procesar el formulario
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            return $this->redirect(['mi-perfil']);
        }
    
        return $this->render('editar-perfil', [
            'model' => $model,
        ]);
    }

    // OJO-REVISAR
    public function actionCambiarEmail()
    {
        // Obtener el modelo del usuario autenticado
        $model = Yii::$app->user->identity;
    
        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }
    
        // Escenario para cambiar el correo electrónico
        $model->setScenario('changeEmail');
    
        // Procesar el formulario
        if ($model->load(Yii::$app->request->post()) && $model->changeEmail()) {
            Yii::$app->session->setFlash('success', 'El correo electrónico se cambió correctamente.');
            return $this->refresh();
        }
    
        return $this->render('cambiar-email', [
            'model' => $model,
        ]);
    }

    public function actionCrearNotificacion($codigo)
    {
        $notificacion = new Notificacion();
        $notificacion->codigo_de_clase = $codigo;
        $notificacion->fecha = date('Y-m-d H:i:s');
        $notificacion->USUARIOid = Yii::$app->user->id;
        // La notificación al administrador, que se puede suponer con ID 1
        $notificacion->USUARIOid2 = 1;

        // No establecer ACTIVIDADid si no es necesario
        $notificacion->ACTIVIDADid = 1;

        if ($notificacion->save()) {
            Yii::$app->session->setFlash('success', 'Notificación creada exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear la notificación.');
        }

        return $this->redirect(['usuario/mi-perfil']);
    }
}