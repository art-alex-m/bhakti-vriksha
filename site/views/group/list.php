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
use yii\helpers\Url;

$this->title = 'Участники группы';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo \yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        'id',
        'profile.fullName',
        'profile.phone',
        'residence.title',
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd.MM.Y, HH:mm'],
            'label' => 'Регистрация'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['class' => 'action-column', 'width' => '60'],
            'contentOptions' => ['class' => 'action-cell'],
            'template' => '{view}{stats}',
            'buttons' => [
                'stats' => function ($url, $model, $key) {
                    $url = Url::to(['/japa/view', 'id' => $model->id]);
                    return Html::a(Html::icon('stats'), $url, ['title' => 'Статистика джапы']);
                },
                'view' => function ($url, $model, $key) {
                    $url = Url::to(['/profile/view', 'id' => $model->id]);
                    return Html::a(Html::icon('eye-open'), $url, ['title' => 'Профиль']);
                },
            ]
        ],
    ],
]);