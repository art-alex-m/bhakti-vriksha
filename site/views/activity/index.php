<?php
/**
 * index.php
 *
 * Просмотр списка действий пользователя на сайте
 *
 * Created by PhpStorm.
 * @date 29.08.18
 * @time 10:41
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $model
 */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Ваша активность на сайте';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo Html::tag('p', 'Показаны последние 10 записей');

echo GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd.MM.Y, HH:mm:ss'],
            'label' => 'Дата',
            'enableSorting' => false,
            'headerOptions' => ['width' => '15%'],
        ],
        'label',
    ],
]);