<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\Roles;
use app\models\UsuarioSearch;
use app\models\Notificacion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RegistroAcciones;
use yii\web\UploadedFile;

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
                'only' => ['editar-perfil', 'mi-perfil', 'create', 'update', 'delete', 'index', 'view'],
                'rules' => [
                    //Solo los administradores pueden realizar estas acciones
                    [
                        'actions' => ['create', 'update', 'delete', 'index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->hasRole([Roles::ADMINISTRADOR, Roles::SYSADMIN]);
                        },
                    ],
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
            if ($model->load($this->request->post()) && $model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Por favor, corrija los errores en el formulario.');
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

        // Manejar la subida de la imagen de perfil
        $model->setScenario('updateProfile');
        if ($model->load(Yii::$app->request->post())) {
            $imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($imageFile) {
                $imageName = 'profile_' . $model->id . '.' . $imageFile->extension;
                $imagePath = 'images/perfiles/' . $imageName;
                if ($imageFile->saveAs(Yii::getAlias('@webroot') . '/' . $imagePath)) {
                    $imagenPerfil = new \app\models\Imagen();
                    $imagenPerfil->ruta_archivo = $imagePath;
                    $imagenPerfil->nombre_Archivo = $imageName;
                    $imagenPerfil->extension = $imageFile->extension;
                    if ($imagenPerfil->save()) {
                        $usuarioImagen = $model->getImagen()->one();
                        if ($usuarioImagen === null) {
                            $usuarioImagen = new \app\models\UsuarioImagen();
                            $usuarioImagen->usuario_id = $model->id;
                        }
                        $usuarioImagen->setImagen($imagenPerfil->id);
                        Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente. Por favor, refresque la página para ver los cambios si es necesario.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error al guardar la imagen de perfil.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error al subir la imagen de perfil.');
                }
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            }
            return $this->refresh();
        }

        // Obtener la imagen de perfil del usuario
        $usuarioImagen = $model->getImagen()->one();
        $imagenPerfil = $usuarioImagen ? $usuarioImagen->imagen : null;
        if ($imagenPerfil === null) {
            //Indicamos la ruta de la imagen por defecto
            $imagenPerfil = new \app\models\Imagen();
            $imagenPerfil->ruta_archivo = Yii::getAlias('@web/images/perfiles/no-photo.png');
        }

        return $this->render('mi-perfil', [
            'model' => $model,
            'imagenPerfil' => $imagenPerfil,
        ]);
    }

    public function actionEditarPerfil()
    {
        // Obtener el modelo del usuario autenticado
        $model = Yii::$app->user->identity;
    
        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }

        // Procesar el formulario de cambio de datos
        $model->setScenario('changeData');
        if ($model->load(Yii::$app->request->post()) && $model->save(false) && $model->changeData()){
            $this->logAction('changeData', 'User changed data');
            Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            return $this->refresh();
        }
    
        return $this->render('editar-perfil', [
            'model' => $model,
        ]);
    }

    public function actionCrearNotificacion($codigo)
    {
        $notificacion = new Notificacion();
        $notificacion->codigo_de_clase = $codigo;
        $notificacion->fecha = date('Y-m-d H:i:s');
        $notificacion->USUARIOid = Yii::$app->user->id;
        // La notificación al administrador, que se ha establecido a 1
        $notificacion->USUARIOid2 = 1;

        // No establecer actividad si no es necesario
        $notificacion->ACTIVIDADid = 1;

        if ($notificacion->save()) {
            Yii::$app->session->setFlash('success', 'Notificación creada exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear la notificación.');
        }

        return $this->redirect(['usuario/mi-perfil']);
    }

    public function actionMisNotificaciones()
    {
        $userId = Yii::$app->user->id;
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Notificacion::find()->where(['USUARIOid2' => $userId, 'fecha_borrado' => null]),
        ]);

        return $this->render('mis-notificaciones', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function logAction($action, $details)
    {
        $log = new RegistroAcciones();
        $log->usuario_accion = Yii::$app->user->identity->nick;
        $log->fecha_accion = date('Y-m-d H:i:s');
        $log->accion = $details;
        $log->save();
    }
}