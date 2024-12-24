<div class="col-xs-9">
<h2 style="display: inline;">Crud con Yii Framework</h2></div>
<div class="col-xs-3">
<a class="btn btn-success" href="<?=Yii::app()->request->baseUrl?>/crud/add">
    Añadir nuevo patrocinador
</a>
</div>
<div style="clear:both"></div>
<hr/>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>APELLIDOS</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
        <th>EDITAR</th>
        <th>ELIMINAR</th>
    </tr>
<?php foreach ($patrocinadores as $patrocinador) { ?>
    <tr>
        <td><?=$patrocinador["id"]?></td>
        <td><?=$patrocinador["nombre"]?></td>
        <td><?=$patrocinador["apellido"]?></td>
        <td><?=$patrocinador["email"]?></td>
        <td><?=substr($patrocinador["password"],0,18)?></td>
        <td>
            <a class="btn btn-primary" href="<?=Yii::app()->
            request->baseUrl?>/crud/modificar/<?=$patrocinador["id"]?>">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
        </td>
        <td>
            <a class="btn btn-danger" href="<?=Yii::app()->request->baseUrl
                    ?>/crud/eliminar/<?=$patrocinador["id"]?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
    </tr>
<?php } ?>
</table>
