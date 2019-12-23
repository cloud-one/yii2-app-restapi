<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v4/activation',
        'tokens' => ['{id}' => '<id:[\\w-]+>'],
        'pluralize' => false,
    ]
];
