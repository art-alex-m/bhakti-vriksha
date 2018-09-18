<?php
/**
 * index.php
 *
 * Отображение агрегированной статистики
 *
 * Created by PhpStorm.
 * @date 18.09.18
 * @time 13:56
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $provider
 * @var string $period
 * @var \app\components\DbTime $current
 */

use \yii\grid\GridView;
use \yii\bootstrap\Html;
use \app\components\DbTime;
use \app\components\DateTruncExpression as DT;
use \yii\bootstrap\Tabs;

$this->title = 'Внутренняя аналитика';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

$today = clone $current;
$previous = clone $current->modify("-1 $period");
$next = clone $current->modify("+2 $period");
$now = new DbTime();

$formatter = function (DbTime $d) use ($period) {
    switch ($period) {
        case DT::PERIOD_WEEK:
            $format = 'dd.MM.yy';
            break;
        case DT::PERIOD_MONTH:
            $format = 'MMM yyyy';
            break;
        default:
            $format = 'dd LLL, EEEEEE';
    }
    return Yii::$app->formatter->asDate($d, $format);
};

\yii\widgets\Pjax::begin([
    'enablePushState' => false,
]);

echo Tabs::widget([
    'navType' => 'nav-pills analytics',
    'renderTabContent' => false,
    'items' => [
        [
            'label' => 'По дням',
            'url' => ['/statistics'],
            'active' => $period == DT::PERIOD_DAY
        ],
        [
            'label' => 'По неделям',
            'url' => ['/statistics', 'p' => DT::PERIOD_WEEK],
            'active' => $period == DT::PERIOD_WEEK
        ],
        [
            'label' => 'По месяцам',
            'url' => ['/statistics', 'p' => DT::PERIOD_MONTH],
            'active' => $period == DT::PERIOD_MONTH
        ],
        ['label' => 'Сегодня', 'url' => ['/statistics', 'p' => $period]],
    ],
]);

$navLinks = <<<HTML
<div class="analytics links">
    <div class="link previous">%s</div>
    <div class="link current">%s</div>
    <div class="link next">%s</div>
</div>
HTML;

printf(
    $navLinks,
    Html::a('<<&nbsp;' . $formatter($previous),
        ['/statistics', 'd' => $previous->getTimestamp(), 'p' => $period]),
    Html::tag('span', $formatter($today)),
    $now > $next
        ? Html::a($formatter($next) . '&nbsp;>>',
        ['/statistics', 'd' => $next->getTimestamp(), 'p' => $period])
        : '');


echo GridView::widget([
    'dataProvider' => $provider,
    'layout' => '{items}',
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'label',
            'label' => 'Наименование',
            'headerOptions' => ['width' => '20%'],
        ],
        'total:integer:Всего',
    ],
]);

\yii\widgets\Pjax::end();