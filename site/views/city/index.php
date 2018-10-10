<?php
/**
 * index.php
 *
 * Отображение городов списком
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 19:57
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Справочник городов';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo Html::beginForm(['/city/create'], 'post');
echo Html::submitButton(Html::icon('plus') . ' Добавить', [
    'class' => 'btn btn-success',
    'name' => 'city-code-create',
    'value' => 1,
]);
echo Html::endForm();

\yii\widgets\Pjax::begin([
    'enablePushState' => false,
]);

echo GridView::widget([
    'dataProvider' => $provider,
    'rowOptions' => function ($model) {
        return $model->status == \app\models\City::STATUS_ARCHIVE ? ['class' => 'blocked'] : [];
    },
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        'title',
        [
            'attribute' => 'status',
            'content' => function ($item) {
                return $item->statusName;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;{delete}',
            'headerOptions' => ['class' => 'action-column', 'width' => '50'],
        ]
    ],
]);

\yii\widgets\Pjax::end();