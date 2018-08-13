<?php
/**
 * Конфигурация базы данных для тестов
 */

$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=postgresql;dbname=bhakti_vriksha_testing';

return $db;
