<?php

namespace app\modules\v4\controllers;

use app\components\BaseController;
use app\models\LeadsActivation;
use Yii;
use yii\web\BadRequestHttpException;

class ActivationsController extends BaseController
{
    public $modelClass = 'app\models\LeadsActivation';
    public $serializer = [
        'class' => 'app\components\FieldsSerializer'
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $headers = Yii::$app->request->headers;
        $bodyParams = Yii::$app->request->bodyParams;

        $campaign_id = $headers->get('campaign_id');
        $custom_variable = $headers->get('custom_variable');

        if (!array_key_exists('codes', $bodyParams)) {
            throw new BadRequestHttpException('codes is required');
        }

        if (array_key_exists('codes', $bodyParams) && !is_array($bodyParams['codes'])) {
            throw new BadRequestHttpException('codes should be an array');
        }

        $tableName = LeadsActivation::tableName();
        $leadsActivation = new LeadsActivation();
        $emptyValues = $leadsActivation->attributes;
        $columns = array_keys($emptyValues);
        $rows = [];

        foreach ($bodyParams['codes'] as $activationCodeFields) {
            $rows[] = array_merge(
              $emptyValues,
              ['campaign_id' => $campaign_id],
              $activationCodeFields
            );
        }

        $batchInsertSql = Yii::$app->db->queryBuilder->batchInsert($tableName, $columns, $rows);

        foreach ($columns as $columnName) {
            $onUpdateFields[] = $columnName. '=VALUES('. $columnName .')';
        }

        $onUpdateSql = ' ON DUPLICATE KEY UPDATE '.implode(',', $onUpdateFields);
        Yii::$app->db->createCommand($batchInsertSql . $onUpdateSql)->execute();

        if ($custom_variable) {
            $sql = 'UPDATE cloudbdc.campaigns SET custom_variable =:custom_variable WHERE campaign_id =:campaign_id';

            $campaign = Yii::$app->db->createCommand($sql)
              ->bindValues([':custom_variable' => $custom_variable, ':campaign_id' => $campaign_id])
              ->execute();
        }

        return $this->asJson([
            "success" => "yes",
            "total_added" => count($rows)
        ]);
    }
}
