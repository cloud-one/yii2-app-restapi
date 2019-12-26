<?php

namespace app\modules\v4\controllers;

use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

use app\components\BaseController;
use app\models\Users;

class UsersController extends BaseController
{
    public $modelClass = 'app\models\Users';
    public $serializer = [
        'class' => 'app\components\FieldsSerializer'
    ];

    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        return $actions;
    }

    public function actionIndex() {
        $this->serializer['defaultFields'] = ['user_id', 'name'];
    
        $headers = \Yii::$app->request->headers;
        $dealer_id = $headers->get('dealer_id');

        if (empty($dealer_id)) {
            throw new BadRequestHttpException('dealer_id is required');
        }

        $query = Users::find()->where('parent_id ='.$dealer_id);

        $activeData = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
                'pageSizeLimit' => [1, 100],
            ],
            'sort' => [
                'defaultOrder' => [
                    'daterange' => SORT_ASC, 
                ]
            ]
        ]);

        return $activeData;
    }

    public function actionView($id) {
        $this->serializer['defaultFields'] = [
          'user_id',
          'name_first',
          'name_last',
          'user_name',
          'phone_cell',
          'phone_work',
          'phone_work_ext'
        ];

        return Users::findOne($id);
    }
}
