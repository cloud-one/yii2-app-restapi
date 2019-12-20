<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v4/users',
        'tokens' => ['{id}' => '<id:[\\w-]+>'],
        'pluralize' => false,
    ]
];
