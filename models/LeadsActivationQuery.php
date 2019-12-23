<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LeadsActivation]].
 *
 * @see LeadsActivation
 */
class LeadsActivationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LeadsActivation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LeadsActivation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
