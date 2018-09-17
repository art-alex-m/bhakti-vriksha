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