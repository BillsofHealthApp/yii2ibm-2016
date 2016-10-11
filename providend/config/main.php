<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-providend',

    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'providend\controllers',
    'bootstrap' => ['log'],

    'modules' => [
        'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ]
    ],
    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Providers',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_providendUser'
            ]
        ],
        'session' => [
            'name' => 'PHPPROVIDSESSID',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            'cookieValidationKey' => 'FcRcOCToWfRRPUUYsjdX',
            'csrfParam' =>'_providendCSRF',
        ],

       'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'enableStrictParsing' => false,
            'rules' => [],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
