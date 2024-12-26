<div class="col-xs-9">
    <h2 style="display: inline;">Crud con Yii2 Framework</h2>
</div>
<div class="col-xs-3">
    <a class="btn btn-success" href="<?= Yii::$app->urlManager->createUrl(['patrocinio/add']) ?>">
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
    <?php foreach ($patrocinadores as $patrocinador): ?>
        <tr>
            <td><?= $patrocinador->id ?></td>
            <td><?= $patrocinador->nombre ?></td>
            <td><?= $patrocinador->apellido ?></td>
            <td><?= $patrocinador->email ?></td>
            <td><?= substr($patrocinador->password, 0, 18) ?></td>
            <td>
                <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['patrocinio/modificar', 'id' => $patrocinador->id]) ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
            </td>
            <td>
                <a class="btn btn-danger" href="<?= Yii::$app->urlManager->createUrl(['patrocinio/eliminar', 'id' => $patrocinador->id]) ?>" 
                   data-method="post" 
                   data-confirm="¿Estás seguro de que deseas eliminar este patrocinador?">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

/*
-- Crear la tabla Patrocinadores
CREATE TABLE Patrocinadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insertar datos de prueba
INSERT INTO Patrocinadores (nombre, apellido, email, password)
VALUES
    ('Juan', 'Pérez', 'juan.perez@example.com', 'password123'),
    ('María', 'López', 'maria.lopez@example.com', 'password456'),
    ('Carlos', 'García', 'carlos.garcia@example.com', 'password789'),
    ('Ana', 'Martínez', 'ana.martinez@example.com', 'password101112');



*/