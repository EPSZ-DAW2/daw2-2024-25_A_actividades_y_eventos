<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
use app\models\ComentarioSearch;
use app\models\ComentarioActividad;
use app\models\ComentarioUsuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Roles;


/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller
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
                        'ajax-create' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['ajax-create'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]);
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Comentario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComentarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comentario model.
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
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Comentario();

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
     * Updates an existing Comentario model.
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
     * Deletes an existing Comentario model.
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
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Devuelve todos los comentarios de usuarios
     */
    public function actionComentariosUsuarios(){
        $comentarios = ComentarioUsuario::find()->with('cOMENTARIO', 'uSUARIO')->all();

        return $this->render('comentarios-usuarios', [
            'comentariosUsuarios' => $comentarios,
        ]);
    }

    /**
     * Devuelve todos los comentarios de actividades
     */
    public function actionComentariosActividades(){
        $comentarios = ComentarioActividad::find()->with('cOMENTARIO', 'aCTIVIDAD')->all();

        return $this->render('comentarios-actividades', [
            'comentariosActividades' => $comentarios,
        ]);
    }

    /**
     * Maneja la creación de comentarios y respuestas mediante AJAX
     * 
     * @return array Respuesta JSON con el resultado de la operación
     */
    public function actionAjaxCreate()
    {
        // Configuramos el formato de respuesta como JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        try {
            // Verificamos que la petición sea AJAX
            if (!Yii::$app->request->isAjax) {
                return ['success' => false, 'error' => 'Método no permitido'];
            }

            // Obtenemos los datos enviados por POST
            $postData = Yii::$app->request->post();
            
            // Si es una respuesta a un comentario, obtenemos la actividad del comentario padre
            if (!empty($postData['comentario_relacionado'])) {
                $parentComment = Comentario::findOne($postData['comentario_relacionado']);
                if ($parentComment) {
                    $postData['ACTIVIDADid'] = $parentComment->ACTIVIDADid;
                }
            }
            
            // Creamos nuevo modelo de comentario y asignamos valores
            $model = new Comentario();
            $model->texto = $postData['texto'];
            $model->ACTIVIDADid = $postData['ACTIVIDADid'];
            $model->USUARIOid = Yii::$app->user->id; // ID del usuario actual
            $model->fecha_bloque = date('Y-m-d H:i:s'); // Fecha actual
            $model->cerrado_comentario = 0; // Inicialmente no está cerrado
            $model->numero_de_denuncias = 0; // Inicialmente sin denuncias
            
            // Si es una respuesta, guardamos la referencia al comentario padre
            if (!empty($postData['comentario_relacionado'])) {
                $model->comentario_relacionado = $postData['comentario_relacionado'];
            }

            // Registramos los datos para debugging
            Yii::debug('Guardando comentario con datos: ' . print_r($model->attributes, true));
            
            // Intentamos guardar el comentario
            if ($model->save()) {
                // Si se guarda exitosamente, devolvemos los datos del comentario
                return [
                    'success' => true,
                    'comentario' => [
                        'id' => $model->id,
                        'texto' => $model->texto,
                        'fecha' => Yii::$app->formatter->asDatetime($model->fecha_bloque),
                        'usuario' => Yii::$app->user->identity->nick,
                    ],
                ];
            }
            
            // Si hay errores al guardar, los registramos y devolvemos
            Yii::error('Error guardando comentario: ' . print_r($model->errors, true));
            return [
                'success' => false,
                'errors' => $model->errors
            ];
            
        } catch (\Exception $e) {
            // Capturamos cualquier error inesperado
            Yii::error('Excepción en actionAjaxCreate: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => YII_DEBUG ? $e->getMessage() : 'Ha ocurrido un error al procesar la solicitud'
            ];
        }
    }

    /**
     * Acción para reportar un comentario
     * 
     * @return array Respuesta JSON con el resultado de la operación
     */
    public function actionReport()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            if (!Yii::$app->request->isAjax) {
                return ['success' => false, 'error' => 'Método no permitido'];
            }

            $postData = Yii::$app->request->post();
            $commentId = $postData['id'];

            $model = Comentario::findOne($commentId);
            if ($model) {
                $model->numero_de_denuncias += 1;
                if ($model->save()) {
                    return ['success' => true];
                } else {
                    return ['success' => false, 'error' => 'Error al guardar el comentario'];
                }
            } else {
                return ['success' => false, 'error' => 'Comentario no encontrado'];
            }
        } catch (\Exception $e) {
            Yii::error('Excepción en actionReport: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Ha ocurrido un error al procesar la solicitud'];
        }
    }
}
