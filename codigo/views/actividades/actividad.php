<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $actividad array */

$this->title = $actividad['titulo'];
?>
<div class="actividad-view">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <!-- Imagen de la actividad si existe -->
                <?php if (!empty($actividad['nombre_Archivo'])): ?>
                    <img class="card-img-top" 
                         src="<?= Yii::getAlias('@web/images/actividades/' . 
                              Html::encode($actividad['nombre_Archivo'] . '.' . 
                              $actividad['extension'])) ?>"
                         alt="<?= Html::encode($actividad['titulo']) ?>">
                <?php else: ?>
                    <img class="card-img-top" 
                         src="<?= Yii::getAlias('@web/images/default.jpg') ?>" 
                         alt="Imagen predeterminada">
                <?php endif; ?>

                <div class="card-body">
                    <h1 class="card-title"><?= Html::encode($actividad['titulo']) ?></h1>
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Detalles del Evento</h5>
                            <p><strong>Fecha:</strong> <?= Yii::$app->formatter->asDateTime($actividad['fecha_celebracion']) ?></p>
                            <p><strong>Duración:</strong> <?= Html::encode($actividad['duracion_estimada']) ?> minutos</p>
                            <p><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion']) ?></p>
                            <p><strong>Edad Recomendada:</strong> <?= Html::encode($actividad['edad_recomendada']) ?> años</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Participación</h5>
                            <p><strong>Participantes:</strong> <?= Html::encode($actividad['participantes']) ?></p>
                            <p><strong>Mínimo:</strong> <?= Html::encode($actividad['minimo_participantes']) ?></p>
                            <p><strong>Máximo:</strong> <?= Html::encode($actividad['maximo_participantes']) ?></p>
                            <p><strong>Reserva disponible:</strong> <?= Html::encode($actividad['reserva'] ? 'Sí' : 'No') ?></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Valoraciones</h5>
                        <div class="d-flex justify-content-start">
                            <!-- Botón de Like -->
                            <?= Html::a('<i class="bi bi-hand-thumbs-up-fill"></i> Me gusta', ['actividades/like', 'id' => $actividad['id']], [
                                'class' => 'btn btn-success btn-sm me-2',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>

                            <!-- Botón de Dislike -->
                            <?= Html::a('<i class="bi bi-hand-thumbs-down-fill"></i> No me gusta', ['actividades/dislike', 'id' => $actividad['id']], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                        </br>
                        <p>
                            <span class="text-success">Votos positivos: <?= Html::encode($actividad['votosOK']) ?></span>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <span class="text-danger">Votos negativos: <?= Html::encode($actividad['votosKO']) ?></span>
                        </p>
                    </div>

                    <?php if (!empty($actividad['detalles']) || !empty($actividad['notas'])): ?>
                        <div class="mb-3">
                            <h5>Información Adicional</h5>
                            <?php if (!empty($actividad['detalles'])): ?>
                                <p><strong>Detalles:</strong> <?= Html::encode($actividad['detalles']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($actividad['notas'])): ?>
                                <p><strong>Notas:</strong> <?= Html::encode($actividad['notas']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Botón para registrarse en la actividad -->
                    <?php
                        // Crear un objeto DateTime a partir de la fecha de celebración
                        $fechaCelebracion = new DateTime($actividad['fecha_celebracion']);

                        // Crear un objeto DateTime para la fecha y hora actual
                        $fechaActual = new DateTime();

                        // Comprobar si la fecha de celebración es anterior a la fecha actual
                        if ($fechaCelebracion > $fechaActual) {
                            echo Html::a('Participar', ['actividades/registrar', 'id' => $actividad['id']], [
                                'class' => 'btn btn-warning',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas participar en esta actividad?',
                                    'method' => 'post',
                                ],
                            ]);
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Esta actividad ya ha finalizado.</div>';
                        }

                        // API Key de Google Maps
                        $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
                        $direccionActividad = Html::encode($actividad['lugar_celebracion']);
                        $direccionEncodedActividad = urlencode($direccionActividad);
                        $urlActividad = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedActividad&components=country:ES&key=$apiKey";
                        $responseActividad = file_get_contents($urlActividad);
                        $dataActividad = json_decode($responseActividad, true);

                        if ($dataActividad['status'] == 'OK')
                        {
                            $latActividad = $dataActividad['results'][0]['geometry']['location']['lat'];
                            $lngActividad = $dataActividad['results'][0]['geometry']['location']['lng'];
                        }
                        else
                        {
                            $latActividad = null;
                            $lngActividad = null;
                        }

                        $this->params['latActividad'] = $latActividad;
                        $this->params['lngActividad'] = $lngActividad;
                        
                        // Agregar mapa de actividad
                        if ($latActividad && $lngActividad) {
                            echo "<div class='mb-4 mt-4' style='display: flex; justify-content: center; align-items: center;'>
                                <div id='map-actividad' style='width: 100%; height: 300px;'></div>
                            </div>";
                        }
                    ?>
                </div>

                <!-- Sección de Comentarios -->
                <div class="card-footer">
                    <h5 class="mb-3">Comentarios</h5>
                    
                    <!-- Formulario para nuevo comentario -->
                    <div class="mb-4">
                        <?= Html::beginForm(['comentario/ajax-create'], 'post', [
                            'class' => 'comment-form',
                            'id' => 'main-comment-form'
                        ]) ?>
                            <div class="form-group">
                                <textarea class="form-control mb-2" name="texto" rows="3" 
                                    placeholder="Escribe tu comentario..." required></textarea>
                                <?= Html::hiddenInput('ACTIVIDADid', $actividad['id']) ?>
                                <?= Html::hiddenInput('_csrf', Yii::$app->request->getCsrfToken()) ?>
                            </div>
                            <?= Html::submitButton('Comentar', [
                                'class' => 'btn btn-primary btn-sm',
                                'id' => 'submit-comment'
                            ]) ?>
                        <?= Html::endForm() ?>
                    </div>

                    <!-- Lista de comentarios -->
                    <?php if (!empty($actividad['comentarios'])): ?>
                        <div class="comentarios-list">
                            <?php foreach ($actividad['comentarios'] as $comentario): ?>
                                <div class="comentario mb-3 border-bottom pb-2">
                                    <div class="d-flex justify-content-between">
                                        <strong><?= Html::encode($comentario['usuario']) ?></strong>
                                        <small class="text-muted"><?= Yii::$app->formatter->asDatetime($comentario['fecha']) ?></small>
                                    </div>
                                    <p class="mb-2"><?= Html::encode($comentario['texto']) ?></p>
                                    
                                    <!-- Botón para responder -->
                                    <button class="btn btn-link btn-sm p-0 reply-btn" 
                                            data-comment-id="<?= $comentario['id'] ?>">
                                        Responder
                                    </button>

                                    <!-- Botón para reportar -->
                                    <button class="btn btn-link btn-sm p-0 report-btn" 
                                            data-comment-id="<?= $comentario['id'] ?>">
                                        Reportar
                                    </button>

                                    <!-- Formulario de respuesta (inicialmente oculto) -->
                                    <div class="reply-form mt-2 d-none" id="reply-form-<?= $comentario['id'] ?>">
                                        <?= Html::beginForm(['comentario/ajax-create'], 'post', [
                                            'class' => 'reply-form-submit'
                                        ]) ?>
                                            <div class="form-group">
                                                <textarea class="form-control mb-2" name="texto" rows="2" 
                                                          placeholder="Escribe tu respuesta..." required></textarea>
                                                <?= Html::hiddenInput('comentario_relacionado', $comentario['id']) ?>
                                            </div>
                                            <?= Html::submitButton('Responder', [
                                                'class' => 'btn btn-secondary btn-sm'
                                            ]) ?>
                                        <?= Html::endForm() ?>
                                    </div>

                                    <!-- Respuestas al comentario -->
                                    <?php if (!empty($comentario['respuestas'])): ?>
                                        <div class="respuestas ms-4 mt-2 border-start border-2 ps-3">
                                            <?php foreach ($comentario['respuestas'] as $respuesta): ?>
                                                <div class="respuesta mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="bi bi-arrow-return-right text-muted me-2"></i>
                                                            <strong><?= Html::encode($respuesta['usuario']) ?></strong>
                                                        </div>
                                                        <small class="text-muted"><?= Yii::$app->formatter->asDatetime($respuesta['fecha']) ?></small>
                                                    </div>
                                                    <p class="mb-1 ms-4"><?= Html::encode($respuesta['texto']) ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No hay comentarios todavía. ¡Sé el primero en comentar!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS
    // Maneja el botón de responder para mostrar/ocultar el formulario de respuesta
    $('.reply-btn').click(function() {
        var commentId = $(this).data('comment-id');
        $('#reply-form-' + commentId).toggleClass('d-none');
    });

    // Maneja el botón de reportar para incrementar el número de denuncias
    $('.report-btn').click(function() {
        var commentId = $(this).data('comment-id');
        var reportBtn = $(this);

        // Verifica si el usuario ya ha reportado este comentario en la sesión actual
        if (sessionStorage.getItem('reported_' + commentId)) {
            alert('Ya has reportado este comentario.');
            return;
        }

        $.ajax({
            url: 'index.php?r=comentario/report',
            type: 'POST',
            data: {
                id: commentId,
                _csrf: yii.getCsrfToken()
            },
            success: function(data) {
                if (data.success) {
                    alert('Comentario reportado exitosamente.');
                    sessionStorage.setItem('reported_' + commentId, true);
                } else {
                    alert('Error al reportar el comentario.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor. Por favor, inténtelo de nuevo.');
            }
        });
    });

    // Maneja el envío del formulario de comentarios principales
    $('#main-comment-form').on('submit', function(e) {
        e.preventDefault(); // Previene el envío tradicional del formulario
        var form = $(this);
        var submitBtn = $('#submit-comment');
        
        // Deshabilita el botón para evitar envíos duplicados
        submitBtn.prop('disabled', true);
        
        // Realiza la petición AJAX para enviar el comentario
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // Token de seguridad
            },
            success: function(data) {
                if (data.success) {
                    // Crea el HTML para el nuevo comentario
                    var newComment = 
                        '<div class="comentario mb-3 border-bottom pb-2">' +
                            '<div class="d-flex justify-content-between">' +
                                '<strong>' + data.comentario.usuario + '</strong>' +
                                '<small class="text-muted">' + data.comentario.fecha + '</small>' +
                            '</div>' +
                            '<p class="mb-2">' + data.comentario.texto + '</p>' +
                            '<button class="btn btn-link btn-sm p-0 reply-btn" data-comment-id="' + data.comentario.id + '">' +
                                'Responder' +
                            '</button>' +
                            '<button class="btn btn-link btn-sm p-0 report-btn" data-comment-id="' + data.comentario.id + '">' +
                                'Reportar' +
                            '</button>' +
                        '</div>';
                    
                    // Añade el nuevo comentario a la lista o crea la lista si no existe
                    if ($('.comentarios-list').length) {
                        $('.comentarios-list').prepend(newComment);
                    } else {
                        $('.text-muted').replaceWith('<div class="comentarios-list">' + newComment + '</div>');
                    }
                    
                    // Limpia el formulario después de enviar
                    form.find('textarea').val('');
                } else {
                    // Maneja los errores mostrando mensajes al usuario
                    console.error('Error del servidor:', data);
                    alert('Error: ' + (data.error || (data.errors ? JSON.stringify(data.errors) : 'Error al guardar el comentario')));
                }
            },
            error: function(xhr, status, error) {
                // Maneja errores de comunicación con el servidor
                console.error('Error AJAX:', {xhr: xhr, status: status, error: error});
                try {
                    var response = JSON.parse(xhr.responseText);
                    alert('Error: ' + (response.message || error));
                } catch (e) {
                    alert('Error en la comunicación con el servidor. Por favor, inténtelo de nuevo.');
                }
            },
            complete: function() {
                // Rehabilita el botón de envío
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Maneja el envío de formularios de respuesta
    $(document).on('submit', '.reply-form-submit', function(e) {
        e.preventDefault(); // Previene el envío tradicional del formulario
        var form = $(this);
        var replyContainer = form.closest('.comentario');
        var submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true);
        
        // Realiza la petición AJAX para enviar la respuesta
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // Token de seguridad
            },
            success: function(data) {
                if (data.success) {
                    // Crea el HTML para la nueva respuesta
                    var newReply = 
                        '<div class="respuesta mb-2">' +
                            '<div class="d-flex justify-content-between">' +
                                '<strong>' + data.comentario.usuario + '</strong>' +
                                '<small class="text-muted">' + data.comentario.fecha + '</small>' +
                            '</div>' +
                            '<p class="mb-1">' + data.comentario.texto + '</p>' +
                        '</div>';
                    
                    // Añade la nueva respuesta al contenedor apropiado
                    var respuestasContainer = replyContainer.find('.respuestas');
                    if (respuestasContainer.length) {
                        respuestasContainer.append(newReply);
                    } else {
                        replyContainer.append('<div class="respuestas ml-4 mt-2">' + newReply + '</div>');
                    }
                    
                    // Limpia y oculta el formulario
                    form.find('textarea').val('');
                    form.closest('.reply-form').addClass('d-none');
                } else {
                    console.error('Error del servidor:', data);
                    alert('Error: ' + (data.error || (data.errors ? JSON.stringify(data.errors) : 'Error al guardar la respuesta')));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', {xhr: xhr, status: status, error: error});
                alert('Error en la comunicación con el servidor. Por favor, inténtelo de nuevo.');
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Inicializa el mapa de Google Maps
    function initMap() {
        var lat = <?= json_encode($latActividad) ?>;
        var lng = <?= json_encode($lngActividad) ?>;
        if (lat && lng) {
            var map = new google.maps.Map(document.getElementById('map-actividad'), {
                center: {lat: lat, lng: lng},
                zoom: 15
            });
            var marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map
            });
        }
    }

    // Carga el script de Google Maps
    var script = document.createElement('script');
    script.src = "https://maps.googleapis.com/maps/api/js?key=<?= $apiKey ?>&callback=initMap";
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
JS;
$this->registerJs($script);
?>
