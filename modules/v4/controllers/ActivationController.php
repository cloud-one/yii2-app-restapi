<?php

namespace app\modules\v4\controllers;

use app\components\BaseController;
use app\models\LeadsActivation;

class ActivationController extends BaseController
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
        $bodyParams = \Yii::$app->request->bodyParams;
        // $tableName = LeadsActivation::tableName();
        // $leadsActivation = new LeadsActivation();
        // $columns = array_keys($leadsActivation->attributes);
        // $rows = [];
        $total_added = 0;

        foreach ($bodyParams['codes'] as $activationCodeFields) {
            $leadsActivation = new LeadsActivation();
            $leadsActivation->attributes = array_merge(
              ['campaign_id' => $bodyParams['campaign_id']],
              $activationCodeFields
            );
            $leadsActivation->save();
            $total_added++;
        }

        // return \Yii::$app->db->createCommand()->batchInsert($tableName, $columns, $rows)->execute();
        return $this->asJson([
          "success" => "yes",
          "total_added" => $total_added
        ]);
    }
}
