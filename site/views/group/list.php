<?php
/**
 * list.php
 *
 * Просмотр членов группы списком
 *
 * Created by PhpStorm.
 * @date 28.08.18
 * @time 13:25
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $model
 */

use yii\bootstrap\Html;

$this->title = 'Участники группы';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo \yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        'id',
        'profile.fullName',
        'profile.phone',
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd.MM.Y, HH:mm'],
            'label' => 'Регистрация'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['class' => 'action-column', 'width' => '50'],
            'contentOptions' => ['class' => 'action-cell'],
            'template' => '{view}',
        ],
    ],
]);