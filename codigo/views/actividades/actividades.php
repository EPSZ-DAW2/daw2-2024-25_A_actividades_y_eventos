<?php
/* @var $this yii\web\View */
/* @var $actividades app\models\Actividad[] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="actividades-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actividades Recomendadas', ['actividades/recomendadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Cercanas', ['actividades/mas-proximas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Nuevas', ['actividades/mas-nuevas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Visitadas', ['actividades/mas-visitadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Pasadas', ['actividades/pasadas-usuario', 'usuarioId' => Yii::$app->user->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <!-- Buscador -->
    <div class="search-container text-center mt-4 mb-4">
        <h2>Buscar Actividades</h2>
        <?= Html::beginForm(['actividades/index'], 'get', ['class' => 'search-form']) ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <?= Html::textInput('q', 
                            Yii::$app->request->get('q'), 
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Buscar por título, descripción o lugar...',
                            ]
                        ) ?>
                        <div class="input-group-append">
                            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?= Html::endForm() ?>
    </div>

    <!-- Resultados de búsqueda -->
    <?php if (isset($dataProvider) && $searchTerm !== ''): ?>
        <div class="search-results mt-4">
            <h3>Resultados de búsqueda para: "<?= Html::encode($searchTerm) ?>"</h3>
            
            <?php if ($dataProvider->getTotalCount() > 0): ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'titulo',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a(
                                    Html::encode($model->titulo),
                                    ['actividades/ver_actividad', 'id' => $model->id],
                                    ['class' => 'activity-title']
                                );
                            }
                        ],
                        'descripcion:ntext',
                        [
                            'attribute' => 'fecha_celebracion',
                            'format' => ['date', 'php:d-m-Y H:i']
                        ],
                        'lugar_celebracion',
                    ],
                    'layout' => "{summary}\n{items}\n{pager}",
                    'emptyText' => 'No se encontraron actividades.',
                    'summary' => 'Mostrando {begin}-{end} de {totalCount} actividades.',
                ]); ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>No se encontraron actividades que coincidan con "<?= Html::encode($searchTerm) ?>"</p>
                    <p>Sugerencias:</p>
                    <ul>
                        <li>Revise la ortografía</li>
                        <li>Use términos más generales</li>
                        <li>Pruebe con menos palabras</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Lista de actividades normal -->
        <div class="row">
            <div class="col-lg-12">
                <h2>Lista de Actividades</h2>
                <?php if (!empty($actividades)): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($actividades as $actividad): ?>
                            <li class="mb-4">
                                <h3><?= Html::encode($actividad->titulo) ?></h3>
                                <p><?= Html::encode($actividad->descripcion) ?></p>
                                <p><strong>Fecha de Celebración:</strong> <?= Yii::$app->formatter->asDate($actividad->fecha_celebracion) ?></p>
                                <?= Html::a('Ver Detalles', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay actividades disponibles en este momento.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$this->registerCss("
    .activity-title { 
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
    .activity-title:hover {
        text-decoration: underline;
    }
");
?>
