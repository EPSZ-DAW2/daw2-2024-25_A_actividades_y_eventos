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


class ActividadesController extends controller
{
    
    // Acción para mostrar todas las actividades
    public function actionIndex()
    {
        $searchTerm = Yii::$app->request->get('q');
        $query = \app\models\Actividad::find();

        if ($searchTerm !== null && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);
            
            $query->where([
                'or',
                ['like', 'titulo', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'descripcion', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'lugar_celebracion', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'detalles', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false],
                ['like', 'notas', '%' . strtr($searchTerm, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%', false]
            ]);

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => ['pageSize' => 10],
                'sort' => ['defaultOrder' => ['fecha_celebracion' => SORT_DESC]]
            ]);

            return $this->render('actividades', [
                'dataProvider' => $dataProvider,
                'searchTerm' => $searchTerm,
                'actividades' => []
            ]);
        }

        // Si no hay búsqueda, mostrar todas las actividades
        return $this->render('actividades', [
            'actividades' => $query->all(),
            'searchTerm' => '',
            'dataProvider' => null
        ]);
    }
    // Muestra las actividades recomendadas
    public function actionRecomendadas()
    {
        $actividades = Actividad::find()
        ->limit(5)
        ->all();
        return $this->render('actividades_recomendadas', [
            'actividades' => $actividades
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
        
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Actividad creada exitosamente.');
                return $this->redirect(['ver_actividad', 'id' => $model->id]);

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

    // MOSTRAR ACTIVIDADES MÁS PRÓXIMAS SEGÚN FECHA DE CELEBRACIÓN
    public function actionMasProximas()
    {
        $actividades = Actividad::find()
            ->where(['>=', 'fecha_celebracion', new \yii\db\Expression('CURDATE()')]) // Filtrar por la fecha actual
            ->orderBy(['fecha_celebracion' => SORT_ASC])  // Ordenar por fecha ascendente
            ->limit(10)  // Limitar a las 10 primeras actividades
            ->all();

        return $this->render('actividades_mas_proximas', [
            'actividades' => $actividades,
        ]);
    }

    
    // MOSTRAR ACTIVIDADES MÁS VISITADAS UTILIZANDO EL CONTADOR DE VISITAS
    public function actionMasVisitadas()
    {
        $actividades = Actividad::find()
            ->orderBy(['contador_visitas' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('actividades_mas_visitadas', [
            'actividades' => $actividades,
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
    public function actionActividadesPasadas()
    {
        $userId = Yii::$app->user->id; // Obtener el ID del usuario actual

        $actividades = Yii::$app->db->createCommand('
            SELECT a.* FROM ACTIVIDAD a
            JOIN PARTICIPA p ON a.id = p.ACTIVIDADid
            WHERE p.USUARIOid = :userId AND a.fecha_celebracion < NOW()
        ')
        ->bindValue(':userId', $userId)
        ->queryAll();

        return $this->render('actividades_pasadas', [
            'actividades' => $actividades,
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
    
}