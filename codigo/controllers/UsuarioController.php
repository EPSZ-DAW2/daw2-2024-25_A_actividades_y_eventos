<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
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
                ],
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
    
    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;

        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'La contraseña ha sido cambiada exitosamente.');
            return $this->redirect(['perfil']); // Cambiar a la página deseada
        }

        return $this->render('changePassword', ['model' => $model]);
    }

    public function actionChangeEmail()
    {
        $model = Yii::$app->user->identity;

        $model->scenario = 'changeEmail';

        if ($model->load(Yii::$app->request->post()) && $model->changeEmail()) {
            Yii::$app->session->setFlash('success', 'El correo electrónico ha sido actualizado exitosamente.');
            return $this->redirect(['perfil']); // Cambiar a la página deseada
        }

        return $this->render('changeEmail', ['model' => $model]);
    }

    public function actionMiPerfil()
    {
        $model = Yii::$app->user->identity;

        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }

        if (Yii::$app->request->post('ChangePasswordForm')) {
            $model->scenario = 'changePassword';
            if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
                Yii::$app->session->setFlash('success', 'La contraseña se cambió correctamente.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo cambiar la contraseña.');
            }
        }

        if (Yii::$app->request->post('ChangeEmailForm')) {
            $model->scenario = 'changeEmail';
            if ($model->load(Yii::$app->request->post()) && $model->changeEmail()) {
                Yii::$app->session->setFlash('success', 'El correo electrónico se cambió correctamente.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo cambiar el correo electrónico.');
            }
        }

        return $this->render('mi-perfil', [
            'model' => $model,
        ]);
    }

    public function actionEditarPerfil()
    {
        $model = Yii::$app->user->identity;

        if (!$model) {
            throw new \yii\web\ForbiddenHttpException('Debe iniciar sesión para acceder a esta página.');
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            return $this->redirect(['mi-perfil']);
        }

        return $this->render('editar-perfil', [
            'model' => $model,
        ]);
    }
}
