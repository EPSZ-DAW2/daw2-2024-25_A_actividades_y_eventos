<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * Controlador para gestionar las copias de seguridad de la base de datos
 * Permite realizar backups y restaurar la base de datos desde archivos SQL
 */
class BackupController extends Controller
{
    /**
     * Muestra la página principal con las opciones de backup y restauración
     * @return string Vista renderizada con el formulario de restauración
     */
    public function actionIndex()
    {
        $model = new \yii\base\DynamicModel(['file']);
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Crea y descarga una copia de seguridad de la base de datos actual
     * Utiliza mysqldump para generar el archivo SQL
     * @return mixed Archivo SQL para descargar o redirección con mensaje de error
     */
    public function actionDownload()
    {
        $db = Yii::$app->db;
        $dsn = $db->dsn;
        // Extraer host y nombre de la base de datos de la cadena de conexión
        preg_match('/host=([^;]*)/', $dsn, $host);
        preg_match('/dbname=([^;]*)/', $dsn, $dbname);

        // Crear directorio de backups si no existe
        $backupPath = Yii::getAlias('@app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        // Ruta al ejecutable mysqldump (ajustar según la instalación)
        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe'; // Para XAMPP en Windows
        // $mysqldumpPath = '/usr/bin/mysqldump'; // Para sistemas Linux

        // Generar nombre único para el archivo de backup
        $fileName = $backupPath . '/backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        // Construir y ejecutar el comando mysqldump
        $command = "\"{$mysqldumpPath}\" --user={$db->username} --password={$db->password} --host={$host[1]} {$dbname[1]} > \"{$fileName}\" 2>&1";

        exec($command, $output, $returnVar);

        // Verificar si el backup se creó correctamente
        if ($returnVar === 0 && file_exists($fileName) && filesize($fileName) > 0) {
            return Yii::$app->response->sendFile($fileName)->send();
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear la copia de seguridad: ' . implode("\n", $output));
            return $this->redirect(['index']);
        }
    }

    /**
     * Restaura la base de datos desde un archivo SQL subido
     * @return mixed Redirección con mensaje de éxito o error
     */
    public function actionUpload()
    {
        if (Yii::$app->request->isPost) {
            $model = new \yii\base\DynamicModel(['file']);
            $model->addRule(['file'], 'file', ['extensions' => 'sql']);
            
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                // Asegurarse de que existe el directorio runtime
                $runtimePath = Yii::getAlias('@app/runtime');
                if (!is_dir($runtimePath)) {
                    mkdir($runtimePath, 0777, true);
                }

                // Asegurarse de que existe el archivo de log
                $logFile = $runtimePath . '/restore.log';
                if (!file_exists($logFile)) {
                    touch($logFile);
                    chmod($logFile, 0666);
                }

                $filePath = Yii::getAlias('@app/backups/') . $model->file->baseName . '.' . $model->file->extension;
                if ($model->file->saveAs($filePath)) {
                    $db = Yii::$app->db;
                    $dsn = $db->dsn;
                    preg_match('/host=([^;]*)/', $dsn, $host);
                    preg_match('/dbname=([^;]*)/', $dsn, $dbname);

                    // Ruta al ejecutable mysql
                    $mysqlPath = 'C:\xampp\mysql\bin\mysql.exe';

                    // Comando con comillas dobles para las rutas y redirección de errores
                    $command = "\"{$mysqlPath}\" -h {$host[1]} -u {$db->username} -p{$db->password} {$dbname[1]} < \"{$filePath}\" 2>&1";

                    // Ejecutar el comando y capturar la salida
                    $output = [];
                    $returnVar = -1;
                    exec($command, $output, $returnVar);

                    // Log más detallado
                    $logMessage = sprintf(
                        "[%s] Intento de restauración\nArchivo: %s\nComando: %s\nCódigo retorno: %d\nSalida: %s\n\n",
                        date('Y-m-d H:i:s'),
                        $filePath,
                        $command,
                        $returnVar,
                        implode("\n", $output)
                    );
                    file_put_contents($logFile, $logMessage, FILE_APPEND);

                    if ($returnVar === 0) {
                        Yii::$app->session->setFlash('success', 'Base de datos restaurada exitosamente.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error al restaurar la base de datos. Código: ' . $returnVar . '. Detalles: ' . implode("\n", $output));
                    }

                    // Limpiar el archivo temporal
                    unlink($filePath);
                } else {
                    Yii::$app->session->setFlash('error', 'Error al guardar el archivo temporal.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Archivo no válido o no seleccionado.');
            }
        }

        return $this->redirect(['index']);
    }
}
