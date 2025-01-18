# LLamadas a la API de la aplicacion

En nuestra aplicación, hemos desarrollado una API de Yii2 para realizar las llamadas a la aplicacion esperando información de actividades y notificaciones y permitiendo operaciones CRUD con las mismas. 
A continuación, se muestra una serie de ejemplos de cómo se realiza una llamada a la API para obtener la lista de usuarios registrados en la aplicación:

**NOTA:** Para realizar las llamadas a la API, es necesario tener un usuario registrado en la aplicación. 

Recuerde cambiar **DIRECTORIO** por el directorio donde se encuentra el proyecto y **nick:password** por el nombre de usuario y contraseña de un usuario registrado en la aplicación.

```textplain
ACTIVIDAD
	INDEX - Devuelve un listado de todas las actividades.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/actividad-index" -u "nick:password"

	VIEW - Devuelve la información de una actividad en concreto.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/actividad-view&id=1" -u "nick:password"

	DELETE - Elimina una actividad en concreto.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/actividad-delete&id=14" -u "nick:password"

	CREATE - Crea una nueva actividad con los datos proporcionados.
	curl -X POST "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/actividad-create" -u "nick:password" -d "titulo=Concierto de Musica&descripcion=Un concierto en el parque con diferentes bandas locales.&fecha_celebracion=2025-02-20%2000:00:00&duracion_estimada=120&lugar_celebracion=Parque Central&detalles=Trae tu manta y disfruta del evento.&notas=Evento gratuito para todas las edades.&edad_recomendada=0&votosOK=100&votosKO=10&maximo_participantes=500&minimo_participantes=50&reserva=1&participantes=150&contador_visitas=2"

	UPDATE - Actualiza los datos de una actividad en concreto.
	curl -X PUT "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/actividad-update&id=1" -u "nick:password" -d "titulo=hola mundo&descripcion=Un concierto en el parque con diferentes bandas locales y algunas sorpresas.&fecha_celebracion=2025-02-20%2000:00:00&duracion_estimada=120&lugar_celebracion=Parque Central&detalles=Trae tu manta y disfruta del evento y participa en la rifa.&notas=Evento gratuito para todas las edades.&edad_recomendada=0&votosOK=120&votosKO=15&maximo_participantes=600&minimo_participantes=50&reserva=1&participantes=200&contador_visitas=5"
```

Tenemos también las llamadas a la API para las notificaciones:

```textplain
NOTIFICACION
	INDEX - Devuelve un listado de todas las notificaciones.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/notificacion-index" -u "nick:password"

	VIEW - Devuelve la información de una notificación en concreto.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/notificacion-view&id=1" -u "nick:password"

	CREATE - Crea una nueva notificación con los datos proporcionados.
	curl -X POST "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/notificacion-create" -u "nick:password" -d "fecha=2025-01-09%2012:35:56&codigo_de_clase=SOLICITUD_BAJA&fecha_lectura=NULL&fecha_borrado=NULL&fecha_aceptacion=NULL&ACTIVIDadid=1&USUARIOid=1&USUARIOid2=1&texto=hola mundo"

	UPDATE - Actualiza los datos de una notificación en concreto.
	curl -X PUT "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/notificacion-update&id=7" -u "nick:password" -d "fecha=2025-01-09%2012:35:56&codigo_de_clase=SOLICITUD_BAJA&fecha_lectura=NULL&fecha_borrado=NULL&fecha_aceptacion=NULL&ACTIVIDadid=1&USUARIOid=1&USUARIOid2=1&texto=Notificación actualizada"

	DELETE - Elimina una notificación en concreto.
	curl -X GET "http://localhost/DIRECTORIO/codigo/web/index.php?r=api/notificacion-delete&id=1" -u "nick:password"
```