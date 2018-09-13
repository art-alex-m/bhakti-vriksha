<?php
/**
 * view.php
 *
 * Просмотр статистики кругов джапы пользователя
 *
 * Created by PhpStorm.
 * @date 28.08.18
 * @time 16:21
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $model
 * @var \app\models\User $user
 */

use \yii\bootstrap\Html;
use \yii\grid\GridView;

$this->title = 'Статистика по кругам джапы';
$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['/group/list']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

if ($user->profile) {
    echo Html::tag('h4', $user->profile->fullName);
}

echo GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd MMMM Y'],
            'label' => 'Дата',
            'headerOptions' => ['width' => '15%'],
        ],
        'number',
    ],
]);