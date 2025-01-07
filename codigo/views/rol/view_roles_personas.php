<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <?= Html::a('Lista de roles', ['index'], ['class' => 'btn btn-secondary']) ?>

<body>
    <table>
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($model) && is_array($model)): ?>
                <?php foreach ($model as $usuario): ?>
                    <tr>
                        <td><?= Html::encode($usuario['id'] ?? $usuario->id ?? 'N/A') ?></td>
                        <td><?= Html::encode($usuario['nick'] ?? $usuario->nick ?? 'N/A') ?></td>
                        <td><?= Html::encode($usuario['email'] ?? $usuario->email ?? 'N/A') ?></td>
                        <td>
                            <?= Html::a('Eliminar Rol', ['rol/delete_rol_persona', 'id' => $usuario['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas eliminar este rol?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay usuarios disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
