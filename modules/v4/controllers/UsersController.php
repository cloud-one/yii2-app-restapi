<?php

namespace app\modules\v4\controllers;

use yii\data\ActiveDataProvider;
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
    
        $params = \Yii::$app->request->queryParams;

        $query = Users::find();

        if (!empty($params) && array_key_exists('dealer_id' , $params)) {
            $query->where('parent_id ='.$params['dealer_id']);
        }

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
