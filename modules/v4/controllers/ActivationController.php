<?php

namespace app\modules\v4\controllers;

use app\components\BaseController;

class ActivationController extends BaseController
{
    public $modelClass = 'app\models\LeadsActivation';
    public $serializer = [
        'class' => 'app\components\FieldsSerializer'
    ];

    public function actions() {
        $actions = parent::actions();
        // unset($actions['index']);
        // unset($actions['view']);
        return $actions;
    }
}
