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
        Yii::$app->response->format = Response::FORMAT_HTML;
        
        try {
            if (!Yii::$app->request->isPost) {
                return $this->redirect(['index']);
            }

            $model = new \yii\base\DynamicModel(['file']);
            $model->addRule(['file'], 'file', [
                'extensions' => 'sql',
                'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, // Importante: no verificar por MIME type
                'maxSize' => 1024 * 1024 * 10 // 10MB max
            ]);

            $uploadedFile = UploadedFile::getInstance($model, 'file');
            
            // Logging para depuración
            Yii::info('Archivo recibido: ' . ($uploadedFile ? $uploadedFile->name : 'ninguno'), 'backup');
            
            if (!$uploadedFile) {
                Yii::$app->session->setFlash('error', 'No se recibió ningún archivo.');
                return $this->redirect(['index']);
            }

            $model->file = $uploadedFile;
            
            if (!$model->validate()) {
                Yii::error('Errores de validación: ' . print_r($model->errors, true), 'backup');
                Yii::$app->session->setFlash('error', 'Error de validación: ' . implode(', ', $model->getFirstErrors()));
                return $this->redirect(['index']);
            }

            // Crear directorio temporal si no existe
            $tempDir = Yii::getAlias('@app/runtime/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // Guardar archivo temporal con nombre único
            $tempFile = $tempDir . '/' . uniqid() . '.sql';
            if (!$model->file->saveAs($tempFile)) {
                Yii::$app->session->setFlash('error', 'Error al guardar el archivo temporal.');
                return $this->redirect(['index']);
            }

            try {
                $db = Yii::$app->db;
                $dsn = $db->dsn;
                preg_match('/host=([^;]*)/', $dsn, $host);
                preg_match('/dbname=([^;]*)/', $dsn, $dbname);

                // Rutas a los ejecutables de MySQL
                $mysqlPath = 'C:\xampp\mysql\bin\mysql.exe';
                
                // Desactivar foreign key checks y eliminar todas las tablas
                $dropCommand = sprintf(
                    '"%s" -h %s -u %s -p%s %s -e "SET FOREIGN_KEY_CHECKS=0; DROP DATABASE IF EXISTS %s; CREATE DATABASE %s; USE %s;"',
                    $mysqlPath,
                    $host[1],
                    $db->username,
                    $db->password,
                    $dbname[1],
                    $dbname[1],
                    $dbname[1],
                    $dbname[1]
                );

                exec($dropCommand . " 2>&1", $dropOutput, $dropReturnVar);

                if ($dropReturnVar !== 0) {
                    throw new \Exception("Error al limpiar la base de datos: " . implode("\n", $dropOutput));
                }

                // Restaurar la base de datos desde el archivo
                $restoreCommand = sprintf(
                    '"%s" -h %s -u %s -p%s %s < "%s"',
                    $mysqlPath,
                    $host[1],
                    $db->username,
                    $db->password,
                    $dbname[1],
                    $tempFile
                );

                exec($restoreCommand . " 2>&1", $output, $returnVar);

                if ($returnVar !== 0) {
                    throw new \Exception("Error al restaurar la base de datos: " . implode("\n", $output));
                }

                // Reactivar foreign key checks
                $finalCommand = sprintf(
                    '"%s" -h %s -u %s -p%s %s -e "SET FOREIGN_KEY_CHECKS=1;"',
                    $mysqlPath,
                    $host[1],
                    $db->username,
                    $db->password,
                    $dbname[1]
                );

                exec($finalCommand);

                Yii::$app->session->setFlash('success', 'Base de datos restaurada exitosamente.');

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } finally {
                // Limpiar archivo temporal
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
            }

            return $this->redirect(['index']);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['index']);
        } finally {
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        // Asegurar que no se cachee la respuesta
        Yii::$app->response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        Yii::$app->response->headers->set('Pragma', 'no-cache');
        Yii::$app->response->headers->set('Expires', '0');
        
        return true;
    }
}
