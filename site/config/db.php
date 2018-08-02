<?php
/**
 * Конфигурация базы данных веб приложения
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=postgresql;dbname=bhakti_vriksha',
    'username' => 'devoted',
    'password' => 'hare_krshna',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
