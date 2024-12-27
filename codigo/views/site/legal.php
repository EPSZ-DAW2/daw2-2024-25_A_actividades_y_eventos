<?php
use yii\helpers\Html;

$this->title = 'Aviso Legal';
?>
<h1>Aviso Legal</h1>
<p>
    En cumplimiento de la Ley 34/2002, de 11 de julio, de servicios de la sociedad de la información y de comercio electrónico (LSSICE), se informa de los siguientes aspectos legales:
</p>

<h2>Datos del Responsable</h2>
<ul>
    <li><strong>Titular:</strong> [Nombre de la Empresa o Persona Física]</li>
    <li><strong>CIF/NIF:</strong> [Número de identificación]</li>
    <li><strong>Domicilio:</strong> Calle Ejemplo 123, 28001, Madrid, España</li>
    <li><strong>Email:</strong> <?= Html::a('contacto@ejemplo.com', 'mailto:contacto@ejemplo.com') ?></li>
    <li><strong>Teléfono:</strong> <?= Html::a('+34 123 456 789', 'tel:+34123456789') ?></li>
</ul>

<h2>Condiciones de Uso</h2>
<p>
    El acceso y uso de esta página web atribuye la condición de usuario, lo que implica la aceptación plena de las condiciones de uso aquí descritas. El usuario se compromete a hacer un uso adecuado del contenido de esta web y a no emplearlo para actividades ilícitas o contrarias a la buena fe y al orden público.
</p>

<h2>Propiedad Intelectual</h2>
<p>
    Todos los contenidos de este sitio web, incluidos textos, gráficos, imágenes, diseño y software, son propiedad de [Nombre de la Empresa], o de terceros que han autorizado su uso, y están protegidos por las leyes de propiedad intelectual.
</p>
