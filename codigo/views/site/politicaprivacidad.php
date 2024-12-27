<?php
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Política de Privacidad';
?>
<h1>Política de Privacidad</h1>
<p>
    En cumplimiento del Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo de 27 de abril de 2016 (RGPD), informamos sobre cómo se recogen, usan y protegen los datos personales que usted proporciona a través de este sitio web.
</p>

<h2>Responsable del Tratamiento</h2>
<ul>
    <li><strong>Titular:</strong> [Nombre de la Empresa o Persona Física]</li>
    <li><strong>Email:</strong> <?= Html::a('contacto@ejemplo.com', 'mailto:contacto@ejemplo.com') ?></li>
</ul>

<h2>Finalidad del Tratamiento</h2>
<p>
    Sus datos personales serán utilizados para:
    <ul>
        <li>Responder a sus consultas y proporcionar información solicitada.</li>
        <li>Gestionar servicios o productos solicitados.</li>
        <li>Enviar comunicaciones comerciales, previo consentimiento.</li>
    </ul>
</p>

<h2>Derechos del Usuario</h2>
<p>
    Usted tiene derecho a acceder, rectificar, suprimir, limitar u oponerse al tratamiento de sus datos, así como a la portabilidad de los mismos. Para ejercer sus derechos, puede contactar al responsable del tratamiento en <?= Html::a('contacto@ejemplo.com', 'mailto:contacto@ejemplo.com') ?>.
</p>
