<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuario;
use app\models\Actividad;
use app\models\RegistroAcciones;
use app\models\Roles;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'admin'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->hasRole([Roles::ADMINISTRADOR, Roles::SYSADMIN]);
                        },
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            if (Yii::$app->user->isGuest) {
                // Usuario no autenticado, mostrar vista index
                $this->layout = 'main'; // Layout para usuarios no autenticados
            } else {
                // Usuario autenticado, redirigir a index2
                return $this->redirect(['site/index2']);
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Esta es la vista principal para usuarios no autenticados.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Esta es la vista principal para usuarios autenticados.
     * En ella se pueden ver ya las actividades disponibles para el usuario
     *
     * @return string
     */
    public function actionIndex2()
    {
        $searchTerm = Yii::$app->request->get('q');
        $db = Yii::$app->db;
        
        // Provider para búsqueda
        $searchProvider = null;
        if ($searchTerm !== null && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);
            $query = Actividad::find();
            
            $query->where([
                'or',
                ['like', 'titulo', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'descripcion', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'lugar_celebracion', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'detalles', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'notas', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false]
            ]);

            $searchProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => ['pageSize' => 10],
                'sort' => ['defaultOrder' => ['fecha_celebracion' => SORT_DESC]]
            ]);
        }

        // Provider para actividades más votadas
        $masVotadasProvider = new ActiveDataProvider([
            'query' => Actividad::find()
                ->orderBy(['votosOK' => SORT_DESC])
                ->limit(6),
            'pagination' => false
        ]);

        // Obtener actividades ordenadas por diferentes criterios
        $actividadesConImagenes = $db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.votosOK DESC 
            LIMIT 6
        ')->queryAll();

        // Providers para los diferentes listados
        $masProximasProvider = new ActiveDataProvider([
            'query' => Actividad::find()
                ->where(['>=', 'fecha_celebracion', new \yii\db\Expression('CURDATE()')])
                ->orderBy(['fecha_celebracion' => SORT_ASC])
                ->limit(6),
            'pagination' => false
        ]);

        $masVisitadasProvider = new ActiveDataProvider([
            'query' => Actividad::find()
                ->orderBy(['contador_visitas' => SORT_DESC])
                ->limit(6),
            'pagination' => false
        ]);

        return $this->render('index2', [
            'searchProvider' => $searchProvider,
            'searchTerm' => $searchTerm,
            'masVotadasProvider' => $masVotadasProvider, // Añadir este provider
            'masProximasProvider' => $masProximasProvider,
            'masVisitadasProvider' => $masVisitadasProvider,
            'actividadesConImagenes' => $actividadesConImagenes,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->logAction('login', 'User logged in');
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->logAction('logout', 'User logged out');
        Yii::$app->user->logout();

        return $this->goHome();
    }

    protected function logAction($action, $details)
    {
        $log = new RegistroAcciones();
        $log->usuario_accion = Yii::$app->user->identity->nick;
        $log->fecha_accion = date('Y-m-d H:i:s');
        $log->accion = $details;
        $log->save();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

        /**
     * Register a new user.
     */

    public function actionRegister()
    {
        $model = new Usuario();
        $model->setScenario('registerNewUser');
    
        if ($model->load(Yii::$app->request->post())) {
            $model->activo = 1;
            $model->fecha_registor = date('Y-m-d H:i:s');
    
            // Generar hash de la contraseña antes de guardar
            $model->setPassword($model->password);
    
            if ($model->save()) {
                // Asignar un rol por defecto al usuario
                $model->asignarRol(Roles::USUARIO_NORMAL); // Rol por defecto: Normal
    
                // Creamos un login form para loguear al usuario directamente
                $login = new LoginForm();
                $login->username = $model->nick;
                $login->password = Yii::$app->request->post('Usuario')['password']; // Tomar la contraseña sin hash
                if ($login->login()) {
                    $this->logAction('register', 'User registered');
                    Yii::$app->session->setFlash('success', 'Usuario registrado correctamente.');
                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', 'Error al iniciar sesión después del registro.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error al registrar el usuario.');
            }
        }
    
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    

    // Nueva acción para la página de política de privacidad
    public function actionPoliticaprivacidad()
    {
        return $this->render('politicaprivacidad');
    }// actionPoliticaprivacidad

    public function actionLegal()
    {
        return $this->render('legal');
    }

    public function actionCookies()
    {
        return $this->render('cookies');
    }
    public function actionAdmin()
    {
        return $this->render('admin');
    }

    public function actionModerador()
    {
        return $this->render('moderador');
    }
}
