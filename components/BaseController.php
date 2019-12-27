<?php

namespace app\components;

use app\components\behaviors\JsxValidator;
use app\models\Clients;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

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
                'Access-Control-Allow-Credentials' => false,
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

    public function beforeAction($action)
    {
        $this->verifyClient();
        $this->verifyOwnership();

        return parent::beforeAction($action);
    }

    public function verifyClient()
    {
        $headers = Yii::$app->request->headers;
        $client_id = $headers->get('client_id');
        $api_key = $headers->get('api_key');

        $client = Clients::find()->where([
          'client_id' => $client_id,
          'api_key' => $api_key
        ])->one();

        if (empty($client)) {
            throw new BadRequestHttpException('Invalid client_id or api_key');
        }

        if (!empty($client) && $client->status != 1) {
            throw new BadRequestHttpException('Your account is inactive');
        }
    }

    function verifyOwnership() {    
        $headers = Yii::$app->request->headers;
        $client_id = $headers->get('client_id');
        $campaign_id = $headers->get('campaign_id');
        $dealer_id = $headers->get('dealer_id');
        $lead_id = $headers->get('lead_id');
        $alert_id = $headers->get('alert_id');
        $user_id = $headers->get('user_id');
        $phone_number = $headers->get('phone_number');
      
        switch (true) {
            case strlen($campaign_id):
                $sql = "
                SELECT 1
                  FROM cloudbdc.campaigns ca
                WHERE ca.campaign_id =:campaign_id
                  AND ca.client_id =:client_id";

                $campaign = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':campaign_id' => $campaign_id])
                  ->queryOne();
                
                if (!$campaign) {
                    # check external_campaign_id
                    $sql = "
                    SELECT 1
                      FROM cloudbdc.campaigns ca
                    WHERE ca.external_campaign_id =:external_campaign_id
                      AND ca.client_id =:client_id";

                    $campaign = Yii::$app->db->createCommand($sql)
                      ->bindValues([':client_id' => $client_id, ':external_campaign_id' => $campaign_id])
                      ->queryOne();  
                }

                if (!$campaign) {
                    throw new NotFoundHttpException('Campaign not found');
                }
            break;

            case strlen($dealer_id):
                $sql = "
                SELECT 1
                  FROM cloudbdc.customers
                WHERE client_id =:client_id
                  AND customer_id =:customer_id";

                $dealer = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':customer_id' => $dealer_id])
                  ->queryOne();
                
                if (!$dealer) {
                    throw new NotFoundHttpException('Dealer not found');
                }
            break;

            case strlen($lead_id):
                $sql = "
                SELECT 1
                  FROM cloudbdc.campaigns ca, cloudbdc.leads l
                WHERE ca.campaign_id = l.campaign_id
                  AND ca.client_id =:client_id
                  AND l.lead_id =:lead_id";

                $lead = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':lead_id' => $lead_id])
                  ->queryOne();
                
                if (!$lead) {
                    throw new NotFoundHttpException('Lead not found');
                }
            break;

            case strlen($alert_id):
                $sql = "
                SELECT 1
                  FROM cloudbdc.campaigns ca, cloudbdc.campaign_customer_alerts cca
                WHERE ca.campaign_id = cca.campaign_id
                  AND ca.client_id =:client_id
                  AND cca.alert_id =:alert_id";

                $alert = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':alert_id' => $alert_id])
                  ->queryOne();
                
                if (!$alert) {
                    throw new NotFoundHttpException('Alert not found');
                }
            break;

            case strlen($user_id):
                $sql = "
                SELECT 1
                  FROM customers c, users u
                WHERE c.customer_id = u.parent_id
                  AND c.client_id =:client_id
                  AND u.user_id =:user_id";

                $user = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':user_id' => $user_id])
                  ->queryOne();
                
                if (!$user) {
                    throw new NotFoundHttpException('User not found');
                }
            break;

            case strlen($phone_number):
                $sql = "
                SELECT 1
                  FROM cloudbdc.customers c, cloudbdc.campaigns ca, cloudbdc.phone_numbers pn
                WHERE c.customer_id = ca.customer_id
                  AND ca.campaign_id = pn.campaign_id
                  AND c.client_id =:client_id
                  AND pn.phone =:phone
                  AND pn.active = 1";

                $phone = Yii::$app->db->createCommand($sql)
                  ->bindValues([':client_id' => $client_id, ':phone' => $phone_number])
                  ->queryOne();
                
                if (!$phone) {
                    throw new NotFoundHttpException('Phone not found');
                }
            break;
        }
    }
}