<?php

namespace app\components;

use app\components\behaviors\JsxValidator;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\Response;

abstract class BaseController extends ActiveController
{
    public function init()
    {
        parent::init();
        Yii::$app->response->charset = 'UTF-8';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $excepts = ['options', 'login'];

        unset($behaviors['authenticator']);

        /*$behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => $excepts
        ];

        $behaviors['jsxValidator'] = [
            'class' => JsxValidator::class,
            'except' => $excepts
        ];*/

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Request-Method' => [
                    'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'
                ],
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Per-Page',
                    'X-Pagination-Total-Count'
                ],
            ]
        ];

        return $behaviors;
    }

    public static function formatModelErrors(array $errors)
    {
        $formattedErrors = [];

        foreach ($errors as $columnName => $errorList) {
            $formattedErrors[] = [
                'field' => $columnName,
                'message' => $errorList[0]
            ];
        }

        return $formattedErrors;
    }
}