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
    'version' => '1.0.0',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];