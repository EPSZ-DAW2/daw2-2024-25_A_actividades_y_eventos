<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Comentario]].
 *
 * @see Comentario
 */
class ComentarioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Comentario[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Comentario|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
