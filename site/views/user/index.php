<?php
/**
 * index.php
 *
 * Просмотр списка всех пользователей системы
 *
 * Created by PhpStorm.
 * @date 11.09.18
 * @time 10:37
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 * @var \app\models\UsersSearch $model
 */

use app\models\UsersSearch;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'layout' => "{summary}\n<div class=\"grid-items\">{items}</div>\n{pager}",
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($item) {
                return Html::a($item->username, ['/profile/view', 'id' => $item->id],
                    ['title' => 'Смотреть профиль']);
            },
        ],
        'profile.lastName',
        'profile.firstName',
        'profile.parentName',
        'profile.phone:text:Телефон',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($item) {
                return Html::a($item->statusName, ['/user/status', 'id' => $item->id],
                    ['title' => 'Изменить статус']);
            },
            'filter' => UsersSearch::getStatusList(),
        ],
        [
            'attribute' => 'role',
            'label' => 'Роль',
            'format' => 'raw',
            'value' => function ($item) {
                $link = empty($item->rolesNames)
                    ? Yii::$app->formatter->nullDisplay
                    : implode(', ', $item->rolesNames);

                return Html::a($link, ['/user/role', 'id' => $item->id],
                    ['title' => 'Изменить роль']);
            },
            'filter' => \app\rbac\Roles::getRolesList(),
        ],
        [
            'attribute' => 'createdAt',
            'format' => ['date', 'dd.MM.Y, HH:mm'],
            'headerOptions' => ['width' => '12%'],
        ],
    ],
]);