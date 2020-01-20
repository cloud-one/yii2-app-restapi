<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v4/activations',
        'tokens' => ['{id}' => '<id:[\\w-]+>'],
        'pluralize' => false,
    ]
];
