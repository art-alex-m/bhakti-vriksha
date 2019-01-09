<?php
/**
 * common.php
 *
 * Базовая конфигурация приложения
 *
 * Created by PhpStorm.
 * @date 02.08.18
 * @time 12:00
 */

return [
    'version' => '1.1.1',
    'language' => 'ru-RU',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
    ],
];