<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Actividad;
use app\models\Clasificacion;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\data\Sort;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;


class ActividadesController extends controller
{
    
    // Acción para mostrar todas las actividades
    public function actionIndex()
    {
        $searchTerm = Yii::$app->request->get('q');
        $query = \app\models\Actividad::find();

        // Filtrado por búsqueda
        if ($searchTerm !== null && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);

            $query->where([
                'or',
                ['like', 'titulo', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false],
                ['like', 'descripcion', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false],
                ['like', 'lugar_celebracion', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false],
                ['like', 'detalles', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false],
                ['like', 'notas', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false],
                ['like', 'id', '%' . strtr($searchTerm, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false] // Añadir búsqueda por id
            ]);
            

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => ['pageSize' => 10],
                'sort' => ['defaultOrder' => ['fecha_celebracion' => SORT_DESC]]
            ]);

            return $this->render('actividades', [
                'dataProvider' => $dataProvider,
                'searchTerm' => $searchTerm,
                'actividades' => [],
            ]);
        }

        // Cargar las imágenes asociadas a las actividades
        $imgActividades = Yii::$app->db->createCommand('
            SELECT i.*, a.id AS actividad_id 
            FROM imagen i
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON i.id = ia.IMAGENid 
            LEFT JOIN actividad a ON ia.ACTIVIDADid = a.id
        ')->queryAll();

        // Si no hay búsqueda, mostrar todas las actividades
        return $this->render('actividades', [
            'actividades' => $query->all(),
            'searchTerm' => '',
            'dataProvider' => null,            
            'imgActividades' => $imgActividades,
        ]);
    }

    

    // Encuentra el modelo de la actividad por ID
    protected function findModel($id)
    {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La actividad solicitada no existe.');
        }
    }

    // Para manejar validación AJAX en el formulario de creación y actualización
    public function actionValidate()
    {
        $model = new Actividad();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return null;
    }

    public function actionAdministrador()
    {
        $sort = new Sort([
            'attributes' => [
                'id',
                'titulo',
                'descripcion',
                'fecha_celebracion',
            ],
        ]);

        $query = Actividad::find()->orderBy($sort->orders);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('panel_administrador', [
            'id' => $countries,
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }

    public function actionVer_actividad($id)
    {
        $model = Actividad::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('La actividad solicitada no existe.');
        }

        // Incrementar el contador de visitas de forma atómica
        Yii::$app->db->createCommand('
            UPDATE ACTIVIDAD 
            SET contador_visitas = contador_visitas + 1 
            WHERE id = :id
        ')->bindValue(':id', $id)->execute();

        return $this->render('ver_actividad', [
            'model' => $model,
        ]);
    }


    // Acción para editar una actividad
    public function actionEditar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actividad actualizada exitosamente.');
            return $this->redirect(['ver_actividad', 'id' => $model->id]);
        }

        return $this->render('editar_actividad', [
            'model' => $model,
        ]);
    }

    // Crea una nueva actividad
    public function actionCrear()
    {
        $model = new Actividad();
    
        if ($model->load(Yii::$app->request->post())) {

            $model->save(false);

            $imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($imageFile) {
                $imageName = $model->titulo . '_' . $model->id . '.' . $imageFile->extension;
                $imagePath = 'images/actividades/' . $imageName;
                if ($imageFile->saveAs(Yii::getAlias('@webroot') . '/' . $imagePath)) {
                    $imagenActividad = new \app\models\Imagen();
                    $imagenActividad->ruta_archivo = $imagePath;
                    $imagenActividad->nombre_Archivo = $imageName;
                    $imagenActividad->extension = $imageFile->extension;
                    if ($imagenActividad->save()) {
                        $actividadImagen = $model->getImagen()->one();
                        if ($actividadImagen === null) {
                            $actividadImagen = new \app\models\ActividadImagen();
                            $actividadImagen->ACTIVIDADid = $model->id;
                        }
                        $actividadImagen->setImagen($imagenActividad->id);
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
            Yii::$app->session->setFlash('success', 'Actividad creada exitosamente.');
            return $this->refresh();

            
            //return $this->redirect(['ver_actividad', 'id' => $model->id]);

        }
    
        return $this->render('crear_actividad', [
            'model' => $model, // Pasa el modelo a la vista
        ]);
    }    
    
    // Elimina una actividad
    public function actionEliminar($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Actividad eliminada exitosamente.');
        return $this->redirect(['actividades/administrador']);
    }

    public function actionVer_participantes_actividad($id)
    {
        $db = Yii::$app->db;

        $model = $db->createCommand('SELECT * FROM USUARIO u JOIN PARTICIPA au ON u.id = au.USUARIOid WHERE au.ACTIVIDADid = :id')
            ->bindValue(':id', $id)
            ->queryAll();

         return $this->render('vista_participantes_actividad', [
             'participantes' => $model,
         ]);
    }

    public function actionVer_etiquetas_actividad($id)
    {
        $db = Yii::$app->db;

        $etiquetas = $db->createCommand('SELECT * FROM ETIQUETAS e JOIN ETIQUETAS_ACTIVIDAD ea on e.id=ea.ETIQUETASid WHERE ea.ACTIVIDADid= :id')
            ->bindValue(':id', $id)
            ->queryAll();

        return $this->render('vista_etiquetas_actividad', [
            'etiquetas' => $etiquetas,
            'id' => $id,
        ]);
    }


    // Muestra las actividades recomendadas
    public function actionRecomendadas()
    {
        // Usar el componente de base de datos de Yii
        $masVotadas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.votosOK DESC 
        ')->queryAll();

        return $this->render('actividades_recomendadas', [
            'masVotadas' => $masVotadas,
        ]);
    }



    // MOSTRAR ACTIVIDADES MÁS PRÓXIMAS SEGÚN FECHA DE CELEBRACIÓN
    public function actionMasProximas()
    {
        $masProximas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion >= CURDATE()
            ORDER BY a.fecha_celebracion ASC 
        ')->queryAll();

        return $this->render('actividades_mas_proximas', [
            'actividades' => $masProximas,
        ]);
    }

    
    // MOSTRAR ACTIVIDADES MÁS VISITADAS UTILIZANDO EL CONTADOR DE VISITAS
    public function actionMasVisitadas()
    {
        $masVisitadas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.contador_visitas DESC 
        ')->queryAll();

        return $this->render('actividades_mas_visitadas', [
            'actividades' => $masVisitadas,
        ]);
    }

    // MOSTRAR LAS MÁS BUSCADAS UTILIZANDO EL VOTOS OK
    public function actionMasBuscadas()
    {
        $actividades = Actividad::find()
            ->orderBy(['votosOK' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('actividades_mas_buscadas', [
            'actividades' => $actividades,
        ]);
    }

    // Acción para mostrar actividades pasadas en las que ha estado el usuario
    public function actionPasadas()
    {
        $Pasadas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion < CURDATE()
            ORDER BY a.fecha_celebracion DESC 
            LIMIT 6
        ')->queryAll();

        return $this->render('actividades_pasadas', [
            'actividades' => $Pasadas,
        ]);
    }

    public function actionSearch($q = '')
    {
        Yii::debug('Recibiendo petición de búsqueda');
        Yii::debug('Parámetro q: ' . $q);
        
        // Asegurar que q no sea null
        $q = trim($q ?? '');
        
        $query = Actividad::find();
        
        if (!empty($q)) {
            $searchTerm = '%' . $q . '%';
            $query->where([
                'or',
                ['like', 'titulo', $searchTerm],
                ['like', 'descripcion', $searchTerm],
                ['like', 'lugar_celebracion', $searchTerm]
            ]);
        }

        Yii::debug('SQL generado: ' . $query->createCommand()->getRawSql());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['fecha_celebracion' => SORT_DESC]
            ],
        ]);

        Yii::debug('Resultados encontrados: ' . $dataProvider->getTotalCount());

        // Si es una petición AJAX, devolver resultados parciales
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('search', [
                'dataProvider' => $dataProvider,
                'searchTerm' => $q,
            ]);
        }

        // Si no es AJAX, renderizar vista completa
        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchTerm' => $q,
        ]);
    }

    public function actionActividad($id)
    {
        $actividad = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM ACTIVIDAD a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN IMAGEN i ON ia.IMAGENid = i.id 
            WHERE a.id = :id')
            ->bindValue(':id', $id)
            ->queryOne();

        if (!$actividad) {
            throw new NotFoundHttpException('La actividad solicitada no existe.');
        }

        return $this->render('actividad', [
            'actividad' => $actividad,
        ]);
    }

    public function actionRegistrar($id)
    {
        $userId = Yii::$app->user->id;
        $fechaInscripcion = date('Y-m-d H:i:s');

        // Check if the user is already registered
        $existingRegistration = Yii::$app->db->createCommand('
            SELECT * FROM PARTICIPA 
            WHERE USUARIOid = :userId AND ACTIVIDADid = :actividadId
        ')
        ->bindValue(':userId', $userId)
        ->bindValue(':actividadId', $id)
        ->queryOne();

        if ($existingRegistration) {
            Yii::$app->session->setFlash('error', 'Ya estás registrado en esta actividad.');
        } else {
            // Register the user for the activity
            Yii::$app->db->createCommand()->insert('PARTICIPA', [
                'USUARIOid' => $userId,
                'ACTIVIDADid' => $id,
                'fecha_inscripcion' => $fechaInscripcion,
                'cancelado' => 0,
            ])->execute();

            Yii::$app->session->setFlash('success', 'Te has registrado exitosamente en la actividad.');
        }

        return $this->redirect(['actividad', 'id' => $id]);
    }

    public function actionMisActividades()
    {
        $userId = Yii::$app->user->id;

        $actividades = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM ACTIVIDAD a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN IMAGEN i ON ia.IMAGENid = i.id 
            JOIN PARTICIPA p ON a.id = p.ACTIVIDADid 
            WHERE p.USUARIOid = :userId AND p.cancelado = 0
        ')
        ->bindValue(':userId', $userId)
        ->queryAll();

        return $this->render('mis-actividades', [
            'actividades' => $actividades,
        ]);
    }

    public function actionDesapuntar($id)
    {
        $userId = Yii::$app->user->id;
        $fechaCancelacion = date('Y-m-d H:i:s');

        Yii::$app->db->createCommand()->update('PARTICIPA', [
            'cancelado' => 1,
            'fecha_cancelacion' => $fechaCancelacion,
        ], 'USUARIOid = :userId AND ACTIVIDADid = :actividadId', [
            ':userId' => $userId,
            ':actividadId' => $id,
        ])->execute();

        Yii::$app->session->setFlash('success', 'Te has desapuntado de la actividad exitosamente.');

        return $this->redirect(['mis-actividades']);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'registrar' => ['POST'],
                    'desapuntar' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['mis-actividades', 'registrar', 'desapuntar'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
}