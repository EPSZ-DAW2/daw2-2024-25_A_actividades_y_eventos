<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Modelo para gestionar los parámetros del servidor
 */
class ParametrosServidor extends Model
{
    public $upload_max_filesize;
    public $memory_limit;

    public function rules()
    {
        return [
            [['upload_max_filesize', 'memory_limit'], 'required'],
            [['upload_max_filesize', 'memory_limit'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'upload_max_filesize' => 'Tamaño máximo de subida',
            'memory_limit' => 'Límite de memoria PHP',
        ];
    }

    public static function getServerInfo()
    {
        return [
            'Sistema Operativo' => PHP_OS,
            'Versión PHP' => PHP_VERSION,
            'Servidor Web' => $_SERVER['SERVER_SOFTWARE'],
            'Base de Datos' => Yii::$app->db->driverName . ' ' . Yii::$app->db->getServerVersion(),
            'Memoria Límite PHP' => ini_get('memory_limit'),
            'Tiempo Máximo Ejecución' => ini_get('max_execution_time') . ' segundos',
            'Tamaño Máximo Upload' => ini_get('upload_max_filesize'),
            'Directorio Root' => Yii::getAlias('@app'),
            'Versión Yii' => Yii::getVersion(),
        ];
    }

    public function updatePhpSettings()
    {
        try {
            // Encontrar la ubicación del php.ini
            $phpIniPath = php_ini_loaded_file();
            if (!$phpIniPath) {
                throw new \Exception('No se pudo encontrar el archivo php.ini');
            }

            // Leer el contenido actual
            $phpIniContent = file_get_contents($phpIniPath);
            if ($phpIniContent === false) {
                throw new \Exception('No se pudo leer el archivo php.ini');
            }

            // Hacer una copia de seguridad
            $backupPath = $phpIniPath . '.backup.' . date('Y-m-d-H-i-s');
            if (!copy($phpIniPath, $backupPath)) {
                throw new \Exception('No se pudo crear copia de seguridad de php.ini');
            }

            // Reemplazar los valores
            $phpIniContent = preg_replace(
                '/^upload_max_filesize\s*=.*$/m',
                'upload_max_filesize = ' . $this->upload_max_filesize,
                $phpIniContent
            );
            $phpIniContent = preg_replace(
                '/^memory_limit\s*=.*$/m',
                'memory_limit = ' . $this->memory_limit,
                $phpIniContent
            );

            // Guardar los cambios
            if (file_put_contents($phpIniPath, $phpIniContent) === false) {
                throw new \Exception('No se pudo escribir en php.ini');
            }

            Yii::$app->session->setFlash('warning', 'Los cambios requieren reiniciar el servidor web para tomar efecto.');
            return true;

        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return false;
        }
    }
}
