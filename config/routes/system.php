<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v4/system/users',
        'tokens' => ['{id}' => '<id:[\\w-]+>'],
        'pluralize' => false,
    ]
];
