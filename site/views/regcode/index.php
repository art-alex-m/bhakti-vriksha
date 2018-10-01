<?php
/**
 * index.php
 *
 * Отображение кодов регистрации списком
 *
 * Created by PhpStorm.
 * @date 27.08.18
 * @time 12:59
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $model
 */

use yii\bootstrap\Html;

$this->title = 'Коды регистрации новых пользователей';
$this->params['breadcrumbs'][] = $this->title;

$txt = <<<TXT
На этой странице вы можете сгенерировать новый код для регистрации участников своей группы
TXT;

echo Html::tag('p', $txt);

echo Html::beginForm(['/regcode/create'], 'post');
echo Html::submitButton(Html::icon('plus') . ' Добавить', [
    'class' => 'btn btn-success',
    'name' => 'reg-code-create',
    'value' => 1,
]);
echo Html::endForm();

echo \yii\grid\GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'expiredAt',
            'format' => ['date', 'dd.MM.Y, HH:mm'],
            'label' => 'Действителен до',
            'headerOptions' => ['width' => '25%'],
        ],
        'code',
    ],
]);