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
use app\models\Etiquetas;
use app\models\Etiqueta;


class ActividadesController extends controller
{
    
    // Método para mostrar el listado de todas las actividades disponibles
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

    

    // Busca y devuelve una actividad por su ID, o lanza excepción si no existe
    protected function findModel($id)
    {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La actividad solicitada no existe.');
        }
    }

    // Validación AJAX para los formularios de creación y actualización
    public function actionValidate()
    {
        $model = new Actividad();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return null;
    }

    // Panel de administración para gestionar actividades
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

    // Muestra los detalles de una actividad específica e incrementa el contador de visitas
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


    // Permite modificar los datos de una actividad existente
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

    // Formulario y lógica para crear una nueva actividad
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
    
    // Elimina una actividad de la base de datos
    public function actionEliminar($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Actividad eliminada exitosamente.');
        return $this->redirect(['actividades/administrador']);
    }

    // Muestra la lista de participantes de una actividad específica
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

    // Muestra las etiquetas asociadas a una actividad
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

    // Muestra las actividades con mejor valoración
    public function actionRecomendadas()
    {
        // Usa el componente de base de datos de Yii para obtener las actividades más votadas
        $masVotadas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.votosOK-a.votosKO DESC 
        ')->queryAll();

        return $this->render('actividades_recomendadas', [
            'masVotadas' => $masVotadas,
        ]);
    }

    // Muestra las actividades ordenadas por fecha de celebración
    public function actionMasProximas()
    {
        // Obtiene actividades del mes actual
        $actividadesEsteMes = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion >= CURDATE() 
            AND MONTH(a.fecha_celebracion) = MONTH(CURDATE())
            ORDER BY a.fecha_celebracion ASC
        ')->queryAll();

        // Obtiene actividades del próximo mes
        $actividadesProximoMes = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion >= CURDATE() 
            AND MONTH(a.fecha_celebracion) = MONTH(CURDATE()) + 1
            ORDER BY a.fecha_celebracion ASC
        ')->queryAll();

        // Obtiene las próximas 3 actividades después del mes siguiente
        $actividadesSiguientes = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.fecha_celebracion > LAST_DAY(CURDATE() + INTERVAL 1 MONTH)
            ORDER BY a.fecha_celebracion ASC
            LIMIT 3
        ')->queryAll();

        return $this->render('actividades_mas_proximas', [
            'actividadesEsteMes' => $actividadesEsteMes,
            'actividadesProximoMes' => $actividadesProximoMes,
            'actividadesSiguientes' => $actividadesSiguientes,
        ]);
    }

    
    // Muestra las actividades ordenadas por número de visitas
    public function actionMasVisitadas()
    {
        $masVisitadas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.contador_visitas > 0
            ORDER BY a.contador_visitas DESC
        ')->queryAll();

        return $this->render('actividades_mas_visitadas', [
            'actividades' => $masVisitadas,
        ]);
    }

    // Muestra las actividades más populares según búsquedas y visitas
    public function actionMasBuscadas()
    {
        $actividades = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            WHERE a.contador_visitas > 1
            ORDER BY a.contador_visitas DESC
        ')->queryAll();


        return $this->render('actividades_mas_buscadas', [
            'actividades' => $actividades,
        ]);
    }

    // Muestra actividades que ya han finalizado
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

    // Muestra las actividades más recientes
    public function actionNuevas()
    {
        $Nuevas = Yii::$app->db->createCommand('
            SELECT a.*, i.nombre_Archivo, i.extension 
            FROM actividad a 
            LEFT JOIN IMAGEN_ACTIVIDAD ia ON a.id = ia.ACTIVIDADid 
            LEFT JOIN imagen i ON ia.IMAGENid = i.id 
            ORDER BY a.id DESC 
            LIMIT 6
        ')->queryAll();

        return $this->render('actividades_nuevas', [
            'actividades' => $Nuevas,
        ]);
    }

    // Implementa la búsqueda de actividades
    public function actionSearch($q = '')
    {
        // Registra la petición de búsqueda para debugging
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

    // Muestra los detalles completos de una actividad y sus comentarios
    public function actionActividad($id)
    {
        $actividad = (new \yii\db\Query())
            ->from('ACTIVIDAD a')
            ->select(['a.*', 'i.nombre_Archivo', 'i.extension']) // Add explicit select
            ->leftJoin('IMAGEN_ACTIVIDAD ia', 'a.id = ia.ACTIVIDADid')
            ->leftJoin('IMAGEN i', 'i.id = ia.IMAGENid')
            ->where(['a.id' => $id])
            ->one();

        // Verificar que la actividad existe
        if (!$actividad) {
            throw new NotFoundHttpException('La actividad no existe.');
        }

        // Obtener comentarios para esta actividad
        $comentarios = (new \yii\db\Query())
            ->select([
                'c.id', 
                'c.texto', 
                'c.fecha_bloque as fecha', 
                'c.comentario_relacionado',
                'u.nick as usuario'
            ])
            ->from(['c' => 'comentario'])
            ->leftJoin(['u' => 'USUARIO'], 'u.id = c.USUARIOid')
            ->where([
                'c.ACTIVIDADid' => $id,
                'c.comentario_relacionado' => null
            ])
            ->orderBy(['c.fecha_bloque' => SORT_DESC])
            ->all();

        // Obtener respuestas para cada comentario
        foreach ($comentarios as &$comentario) {
            $comentario['respuestas'] = (new \yii\db\Query())
                ->select([
                    'c.id', 
                    'c.texto', 
                    'c.fecha_bloque as fecha',
                    'u.nick as usuario'
                ])
                ->from(['c' => 'comentario'])
                ->leftJoin(['u' => 'USUARIO'], 'u.id = c.USUARIOid')
                ->where([
                    'c.ACTIVIDADid' => $id,
                    'c.comentario_relacionado' => $comentario['id']
                ])
                ->orderBy(['c.fecha_bloque' => SORT_ASC])
                ->all();
        }

        $actividad['comentarios'] = $comentarios;

        return $this->render('actividad', [
            'actividad' => $actividad,
        ]);
    }

    // Procesa la inscripción de un usuario en una actividad
    public function actionRegistrar($id)
    {
        $userId = Yii::$app->user->id;
        $fechaInscripcion = date('Y-m-d H:i:s');

        // Verificar si el usuario ya está registrado
        $existingRegistration = Yii::$app->db->createCommand('
            SELECT * FROM PARTICIPA 
            WHERE USUARIOid = :userId AND ACTIVIDADid = :actividadId
        ')
        ->bindValue(':userId', $userId)
        ->bindValue(':actividadId', $id)
        ->queryOne();

        if ($existingRegistration) {
            if ($existingRegistration['cancelado'] == 1 && $existingRegistration['fecha_cancelacion'] !== null) {
                // Eliminar la inscripción anterior
                Yii::$app->db->createCommand()->delete('PARTICIPA', [
                    'USUARIOid' => $userId,
                    'ACTIVIDADid' => $id,
                ])->execute();

                // Crear una nueva inscripción
                Yii::$app->db->createCommand()->insert('PARTICIPA', [
                    'USUARIOid' => $userId,
                    'ACTIVIDADid' => $id,
                    'fecha_inscripcion' => $fechaInscripcion,
                    'cancelado' => 0,
                ])->execute();

                Yii::$app->session->setFlash('success', 'Te has registrado nuevamente en la actividad.');
            } else {
                Yii::$app->session->setFlash('error', 'Ya estás registrado en esta actividad.');
            }
        } else {
            // Registrar al usuario para la actividad
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

    // Muestra las actividades en las que está inscrito el usuario actual
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

    // Permite a un usuario cancelar su participación en una actividad
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

    // Configuración de comportamientos del controlador
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

    // Muestra actividades agrupadas por etiquetas
    public function actionActividadesEtiquetas()
    {
        $etiquetas = Etiqueta::find()->with('actividades')->all();

        return $this->render('actividades-etiquetas', [
            'etiquetas' => $etiquetas,
        ]);
    }

    // Permite a un usuario seguir todas las actividades de una etiqueta
    public function actionSeguirEtiqueta($id)
    {
        $userId = Yii::$app->user->id;
        $fechaSeguimiento = date('Y-m-d H:i:s');

        $actividades = Etiqueta::findOne($id)->actividades;

        foreach ($actividades as $actividad) {
            Yii::$app->db->createCommand()->insert('SIGUE', [
                'USUARIOid' => $userId,
                'ACTIVIDADid' => $actividad->id,
                'fecha_seguimiento' => $fechaSeguimiento,
            ])->execute();
        }

        Yii::$app->session->setFlash('success', 'Ahora sigues esta etiqueta.');
        return $this->redirect(['actividades-etiquetas']);
    }

    // Permite a un usuario dejar de seguir las actividades de una etiqueta
    public function actionDejarSeguirEtiqueta($id)
    {
        $userId = Yii::$app->user->id;

        $actividades = Etiqueta::findOne($id)->actividades;

        foreach ($actividades as $actividad) {
            Yii::$app->db->createCommand()->delete('SIGUE', [
                'USUARIOid' => $userId,
                'ACTIVIDADid' => $actividad->id,
            ])->execute();
        }

        Yii::$app->session->setFlash('success', 'Has dejado de seguir esta etiqueta.');
        return $this->redirect(['actividades-etiquetas']);
    }

    // Registra un voto positivo para una actividad
    public function actionLike($id)
    {
        $actividad = Actividad::findOne($id);
        if ($actividad) {
            // Verificamos si el usuario ya votó
            if (!Yii::$app->session->get("voto_actividad_{$id}")) {
                $actividad->votosOK += 1;  // Incrementamos los votos positivos
                $actividad->save();
                
                // Guardamos en la sesión que el usuario ha votado
                Yii::$app->session->set("voto_actividad_{$id}", 'like');
            }
        }
    
        // Redirigimos de nuevo a la página anterior o a la vista de la actividad si no hay referencia
        return $this->redirect(Yii::$app->request->referrer ?: ['actividad/view', 'id' => $id]);
    }
    
    // Registra un voto negativo para una actividad
    public function actionDislike($id)
    {
        $actividad = Actividad::findOne($id);
        if ($actividad) {
            // Verificamos si el usuario ya votó
            if (!Yii::$app->session->get("voto_actividad_{$id}")) {
                $actividad->votosKO += 1;  // Incrementamos los votos negativos
                $actividad->save();
                
                // Guardamos en la sesión que el usuario ha votado
                Yii::$app->session->set("voto_actividad_{$id}", 'dislike');
            }
        }
    
        // Redirigimos de nuevo a la página anterior o a la vista de la actividad si no hay referencia
        return $this->redirect(Yii::$app->request->referrer ?: ['actividad/view', 'id' => $id]);
    }
    

}