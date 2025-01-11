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

        $imgActividades = $db->createCommand('
            SELECT i.*, a.fecha_celebracion, a.id AS actividad_id 
            FROM imagen i
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON i.id = ia.IMAGENid 
            LEFT JOIN actividad a ON ia.ACTIVIDADid = a.id 
            WHERE a.fecha_celebracion >= CURDATE()
            ORDER BY RAND()
            LIMIT 5
        ')->queryAll();



        /*$imgActividades = $db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY RAND()
            LIMIT 5
        ')->queryAll();*/


        // Obtener actividades ordenadas por diferentes criterios
        $masVotadas = $db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.votosOK DESC 
            LIMIT 4
        ')->queryAll();


        $masProximas = $db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion >= CURDATE()
            ORDER BY a.fecha_celebracion ASC 
            LIMIT 4
        ')->queryAll();


        $masVisitadas = $db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.contador_visitas DESC 
            LIMIT 4
        ')->queryAll();
        
        // Array con los nombres de las categorías
        $categorias = [
            'Todas' => 'actividades/index',
            //'Mas Buscadas' => 'actividades/mas-buscadas',
            'Próximas' => 'actividades/mas-proximas',
            'Más Visitadas' => 'actividades/mas-visitadas',
            'Pasadas' => 'actividades/pasadas',
            'Recomendadas' => 'actividades/recomendadas',
            'Nuevas' => 'actividades/nuevas',
        ];


        return $this->render('index2', [
            'searchProvider' => $searchProvider,
            'searchTerm' => $searchTerm,
            'imgActividades' => $imgActividades,
            'masVotadas' => $masVotadas, 
            'masProximas' => $masProximas,
            'masVisitadas' => $masVisitadas,
            'categorias' => $categorias,
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
        if ($model->load(Yii::$app->request->post())) {
            $user = Usuario::findOne(['nick' => $model->username]);
            if($user !== null ){
                if ($user->activo == 0){
                    Yii::$app->session->setFlash('error', 'Tu cuenta está bloqueada debido a múltiples intentos fallidos de inicio de sesión.');
                    return $this->refresh();
                }

                if ($model->login()){
                    $model->intentos_acceso = 0; // Reinicia los intentos fallidos al iniciar sesión correctamente
                    $this->logAction('login', 'User logged in');
                    return $this->goHome();
                } else {
                    $model->intentos_acceso+=1;
                    if ($model->intentos_acceso > 3){
                        $user->activo = 0;
                        $user->motivo_bloqueo = 'Múltiples intentos fallidos de inicio de sesión';
                        $user->fecha_bloqueo = date('Y-m-d H:i:s');
                        $user->save(false);
                        Yii::$app->session->setFlash('error', 'Tu cuenta se encuentra bloqueada. Contacte con un administrador para resolverlo el problema.');
                    } else {
                        Yii::$app->session->setFlash('error', "Contraseña incorrecta. Intento $model->intentos_acceso de 3.");
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Usuario o contraseña incorrectos.');
            }
            return $this->refresh();
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
