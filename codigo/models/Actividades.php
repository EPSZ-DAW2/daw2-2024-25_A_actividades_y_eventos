<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividades".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string|null $fecha_celebracion
 * @property string|null $duracion_estimada
 * @property string|null $lugar_celebracion
 * @property string|null $detalles
 * @property string|null $notas
 * @property string|null $url_externa
 * @property string|null $imagen_principal
 * @property string|null $imagenes_adicionales
 * @property string|null $edad_recomendada
 * @property string|null $etiquetas
 * @property float|null $clasificacion
 * @property string|null $estado_actividad
 * @property string|null $patrocinios
 * @property int|null $seguimientos
 * @property int|null $participacion
 * @property int|null $valoracion
 * @property string|null $comentarios
 * @property string|null $registro_usuario
 * @property string|null $notas_adicionales
 */
class Actividades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Reglas para los campos requeridos
            [['titulo', 'descripcion'], 'required'],
            
            // Reglas para los campos de texto largo
            [['descripcion', 'detalles', 'notas', 'estado_actividad', 'patrocinios', 'notas_adicionales'], 'string'],
            
            // Reglas para los campos de fecha
            [['fecha_celebracion', 'duracion_estimada', 'imagenes_adicionales', 'etiquetas', 'comentarios', 'registro_usuario'], 'safe'],
            
            // Validación de tipo numérico
            [['clasificacion'], 'number'],
            [['seguimientos', 'participacion', 'valoracion'], 'integer'],
            
            // Validación para campos de texto con longitud máxima
            [['titulo', 'lugar_celebracion', 'imagen_principal'], 'string', 'max' => 255],
            [['url_externa'], 'string', 'max' => 2083],
            [['edad_recomendada'], 'string', 'max' => 50],
            
            // Validación de URL externa
            [['url_externa'], 'url'],
            
            // Validación de imagen principal (puedes agregar una validación adicional si se trata de archivos)
            [['imagen_principal'], 'file', 'extensions' => 'jpg, jpeg, png', 'maxSize' => 1024*1024*5], // Máximo 5MB por ejemplo
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'fecha_celebracion' => 'Fecha de Celebración',
            'duracion_estimada' => 'Duración Estimada',
            'lugar_celebracion' => 'Lugar de Celebración',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'URL Externa',
            'imagen_principal' => 'Imagen Principal',
            'imagenes_adicionales' => 'Imágenes Adicionales',
            'edad_recomendada' => 'Edad Recomendada',
            'etiquetas' => 'Etiquetas',
            'clasificacion' => 'Clasificación',
            'estado_actividad' => 'Estado de Actividad',
            'patrocinios' => 'Patrocinios',
            'seguimientos' => 'Seguimientos',
            'participacion' => 'Participación',
            'valoracion' => 'Valoración',
            'comentarios' => 'Comentarios',
            'registro_usuario' => 'Registro de Usuario',
            'notas_adicionales' => 'Notas Adicionales',
        ];
    }
}