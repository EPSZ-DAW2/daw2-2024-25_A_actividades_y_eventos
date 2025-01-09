<?php

namespace app\controllers;

use Yii;
use app\models\Roles;
use app\models\Usuario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;

/**
 * RolController implements the CRUD actions for Roles model.
 */
class RolController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'assign'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->hasRole([Roles::SYSADMIN]);
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Roles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Roles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Roles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'usuarios' => $this->getUsuariosPorRol($id),
        ]);
    }

    /**
     * Creates a new Roles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Roles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        Yii::$app->session->setFlash('success', 'Rol creado exitosamente.');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Roles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        Yii::$app->session->setFlash('success', 'Rol actualizado exitosamente.');

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Roles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Rol borrado exitosamente.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the Roles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Roles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Roles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

    public function getUsuariosPorRol($id){
        $model = $this->findModel($id);
        $usuarios = $model->getUsuarios()->all();
        return $usuarios;
    }

    public function actionDelete_rol_persona($id)
    {
        $db = Yii::$app->db;

        $db->createCommand('DELETE FROM USUARIO_ROLES WHERE USUARIOid = :id')
            ->bindValue(':id', $id)
            ->execute();

        Yii::$app->session->setFlash('success', 'Rol eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    public function actionAdd_rol_persona()
    {
        $model = new Roles();

        $usuarios = new Usuario();

        return $this->render('assign', [
            'model' => $model,
            'usuarios' => $usuarios,

        ]);
    }

    public function actionAssign()
    {
        $db = Yii::$app->db;

        $usuario = Yii::$app->request->post('usuario');
        $rol = Yii::$app->request->post('rol');

        if ($usuario !== null && $rol !== null) {
            $db->createCommand('INSERT INTO USUARIO_ROLES (USUARIOid, ROLESid) VALUES (:usuario, :rol)')
                ->bindValue(':usuario', $usuario)
                ->bindValue(':rol', $rol)
                ->execute();

            Yii::$app->session->setFlash('success', 'Rol asignado exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Datos inválidos. Por favor, seleccione un usuario y un rol.');
        }

        return $this->redirect(['index']);
    }

}
