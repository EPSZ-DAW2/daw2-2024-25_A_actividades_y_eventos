<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

$this->title = 'Resultados de búsqueda';
?>

<div class="actividad-search">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- Formulario de búsqueda en la página de resultados -->
    <div class="search-form mb-4">
        <form action="<?= Yii::$app->urlManager->createUrl(['actividades/search']) ?>" method="get">
            <div class="input-group">
                <input type="text" name="q" class="form-control" 
                       value="<?= Html::encode($searchTerm) ?>" 
                       placeholder="Buscar actividades...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($searchTerm): ?>
        <p>Resultados para: <strong><?= Html::encode($searchTerm) ?></strong></p>
    <?php endif; ?>

    <?php if ($dataProvider->getTotalCount() > 0): ?>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'titulo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a(
                                Html::encode($model->titulo),
                                ['ver_actividad', 'id' => $model->id],
                                ['class' => 'activity-title']
                            );
                        }
                    ],
                    [
                        'attribute' => 'descripcion',
                        'format' => 'ntext',
                        'contentOptions' => ['class' => 'description-cell']
                    ],
                    [
                        'attribute' => 'fecha_celebracion',
                        'format' => ['date', 'php:d-m-Y H:i'],
                        'contentOptions' => ['class' => 'date-cell']
                    ],
                    [
                        'attribute' => 'lugar_celebracion',
                        'contentOptions' => ['class' => 'location-cell']
                    ],
                ],
                'layout' => "{summary}\n{items}\n{pager}",
                'emptyText' => 'No se encontraron actividades.',
                'summary' => 'Mostrando {begin}-{end} de {totalCount} actividades.',
            ]); ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <?php if ($searchTerm): ?>
                <h4>No se encontraron actividades que coincidan con "<?= Html::encode($searchTerm) ?>"</h4>
                <p>Sugerencias:</p>
                <ul>
                    <li>Revise la ortografía de las palabras</li>
                    <li>Use términos más generales</li>
                    <li>Pruebe con menos palabras</li>
                    <li>Intente con sinónimos</li>
                </ul>
            <?php else: ?>
                <p>Ingrese un término de búsqueda para encontrar actividades.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php
// Agregar estilos CSS para mejorar la presentación
$this->registerCss("
    .activity-title { 
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
    .activity-title:hover {
        text-decoration: underline;
    }
    .description-cell {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .date-cell {
        white-space: nowrap;
    }
    .location-cell {
        max-width: 200px;
    }
");
?>
