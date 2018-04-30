<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/system/users',
        'tokens' => ['{id}' => '<id:[\\w-]+>'],
        'pluralize' => false,
    ]
];
