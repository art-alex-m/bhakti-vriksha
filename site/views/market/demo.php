<?php
/**
 * demo.php
 *
 * Отображение демонстрационной статистики по рынку святого имени
 *
 * Created by PhpStorm.
 * @date 11.10.18
 * @time 16:54
 * @since 1.1.0
 *
 * @var \yii\web\View $this
 */

use yii\bootstrap\Tabs;
use yii\helpers\Html;

\app\assets\C3ChartAsset::register($this);

$this->title = 'Статистика рынка (демо)';
$this->params['breadcrumbs'][] = ['label' => 'Статистика рынка', 'url' => ['/market/']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', 'Демонстрационная статистика развития рынка');

echo Html::beginTag('div', ['class' => 'col-md-7', 'style' => 'padding-left:0']);
echo Html::tag('p', 'На данной странице вы можете видеть состояние графиков, когда система 
работает уже какое-то время. Для просмотра текущей ситуации перейдите на 
<a href="/market/">реальные данные.</a>');
echo Html::endTag('div');

echo Html::tag('div', '', ['style' => 'clear:both;']);

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Участники',
            'active' => true,
            'content' => $this->render('chartUsers', ['dataUri' => '/c3-chart/users-amount-demo']),
        ],
        [
            'label' => 'Круги',
            'content' => $this->render('chartJapa', ['dataUri' => '/c3-chart/japa-amount-demo']),
        ],
    ]
]);


$c3 = <<<JS
var c3FormatBuilder = function(format) {
    let labelFormat;
    switch (format) {
        case 'year':
            labelFormat = '%Y';
            break;
        case 'month':
            labelFormat = '%m.%Y';
            break;
        default:
            labelFormat = '%e.%m';                                    
    } 
    return d3.timeFormat(labelFormat);
};
JS;

$this->registerJs($c3, \yii\web\View::POS_END);

