<?php
/**
 * index.php
 *
 * Просмотр данных статистики джапы списком
 *
 * Created by PhpStorm.
 * @date 23.08.18
 * @time 10:39
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $model
 * @var bool $newJapa
 * @var DateInterval $japaTime
 * @var string $userName
 */

use yii\bootstrap\Html;

$this->title = 'Статистика по кругам джапы';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo Html::tag('h4', $userName);

echo Html::tag('p', 'Данные о повторении кругов необходимо обновлять 1 раз в месяц');

$btnClass = 'btn-success';
if ($japaTime->m > 0) {
    $btnClass = 'btn-danger';
}

if ($newJapa) {
    echo Html::beginTag('p');
    echo Html::a('Обновить данные', ['/japa/create'], ['class' => ['btn', $btnClass]]);
    echo Html::endTag('p');
}

if (!$newJapa) {
    echo Html::beginTag('p');
    echo 'До следующего обновления осталось ';
    echo Yii::t('app', 'JAPA_DAYS_LEFT', ['n' => $japaTime->days]);
    echo ' ';
    echo Yii::t('app', 'JAPA_HOURS_LEFT', ['n' => $japaTime->h]);
    echo ' ';
    echo Yii::t('app', 'JAPA_MIN_LEFT', ['n' => $japaTime->i]);
    echo Html::endTag('p');
}

echo \yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd MMMM Y'],
            'label' => 'Дата',
        ],
        'number',
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['class' => 'action-column', 'width' => '50'],
            'contentOptions' => ['class' => 'action-cell'],
            'template' => '{update}',
        ],
    ],
]);