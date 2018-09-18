<?php
/**
 * bootstrap.php
 *
 * Created by PhpStorm.
 * @date 17.09.18
 * @time 14:39
 */

Yii::$container->set('yii\grid\ActionColumn', [
    'contentOptions' => ['class' => 'action-cell'],
]);
Yii::$container->set('yii\web\JqueryAsset', [
    'js' => ['jquery.min.js'],
]);
Yii::$container->set('yii\bootstrap\BootstrapAsset', [
    'css' => ['css/bootstrap.min.css'],
]);
Yii::$container->set('yii\bootstrap\BootstrapPluginAsset', [
    'js' => ['js/bootstrap.min.js'],
]);