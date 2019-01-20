<?php
/**
 * index.php
 *
 * Страница лендинга.
 *
 * Created by PhpStorm.
 * @date 10.10.18
 * @time 15:11
 * @since 1.1.0
 */

use yii\helpers\Html;

$this->title = 'Главная';
?>

<ul class="breadcrumb">
    <li><?= $this->title ?></li>
</ul>

<h2>Центр развития Рынка Святого Имени</h2>

<div class="group" style="margin: 25pt 0 0 0;">
    <?= Html::a('Присоединиться',
        ['/registration'],
        ['class' => 'btn btn-default']) ?>
    <?= Html::a('У меня уже есть аккаунт', ['/site/login'],
        ['style' => ['display' => 'block', 'margin-top' => '1em']]) ?>
</div>
