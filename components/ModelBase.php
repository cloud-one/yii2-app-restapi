<?php

namespace app\components;

use app\components\behaviors\DbAttributesFilterBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property bool status
 */
class ModelBase extends ActiveRecord
{
    /**
     * @var string Label para as colunas ID
     */
    protected $idLabel = 'ID';

    /**
     * @var string Label para as colunas created_at
     */
    protected $createdAtLabel = 'Created Datetime';

    /**
     * @var string Label para as colunas updated_at
     */
    protected $updateAtLabel = 'Last Updated';

    /**
     * @var string Label para as colunas user_ins_id
     */
    protected $createdByLabel = 'Created By';

    /**
     * @var string Label para as colunas user_ins_id
     */
    protected $updatedByLabel = 'Last Updated By';

    /**
     * @var string Label oara os status
     */
    protected $statusLabel = 'Active';

    /**
     * @var string Nome da coluna que representa o created_at
     */
    private $createdAtAttribute = 'created_at';

    /**
     * @var string Nome da coluna que representa o updated_at
     */
    private $updatedAtAttribute = 'updated_at';

    /**
     * @var string Nome da coluna que representa o created_by
     */
    private $createdByAttribute = 'created_by';

    /**
     * @var string Nome da coluna que representa o updated_by
     */
    private $updatedByAttribute = 'updated_by';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => DbAttributesFilterBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => $this->getCreatedAtAttribute(),
                'updatedAtAttribute' => $this->getUpdatedAtAttribute(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => $this->getCreatedByAttribute(),
                'updatedByAttribute' => $this->getUpdatedByAttribute()
            ]
        ];
    }

    /**
     * Metodo generico para auxiliar na montagem dos dropdown dos formularios
     * @param string $labelColumn Coluna/propriedade que representa o label do dropdown
     * @param string $keyColumn Coluna/propriedade que representa o valor do dropdown
     * @param string $order Ordenacao da consulta, caso seja necessaria
     * @return array
     */
    public static function getDropdownOptions($labelColumn, $keyColumn = 'id', $order = null)
    {
        $list = [];
        $rows = self::find()
                    ->select([$labelColumn, $keyColumn])
                    ->orderBy(!is_null($order) ? $order : "\"{$labelColumn}\" ASC")
                    ->all();

        foreach ($rows as $row) {
            $list[] = [
                'label' => $row[$labelColumn],
                'value' => $row[$keyColumn]
            ];
        }

        return $list;
    }

    /**
     * Metodo que retorna o nome do atributo created_at do model
     * @return bool|string
     */
    private function getCreatedAtAttribute()
    {
        return (array_key_exists($this->createdAtAttribute, $this->attributes) ? $this->createdAtAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo updated_at do model
     * @return bool|string
     */
    private function getUpdatedAtAttribute()
    {
        return (array_key_exists($this->updatedAtAttribute, $this->attributes) ? $this->updatedAtAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo created_by do model
     * @return bool|string
     */
    private function getCreatedByAttribute()
    {
        return (array_key_exists($this->createdByAttribute, $this->attributes) ? $this->createdByAttribute : false);
    }

    /**
     * Metodo que retorna o nome do atributo updated_by do model
     * @return bool|string
     */
    private function getUpdatedByAttribute()
    {
        return (array_key_exists($this->updatedByAttribute, $this->attributes) ? $this->updatedByAttribute : false);
    }
}
