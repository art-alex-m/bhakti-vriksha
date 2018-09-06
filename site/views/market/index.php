<?php
/**
 * index.php
 *
 * Отображение статистики по рынку святого имени
 *
 * Created by PhpStorm.
 * @date 03.09.18
 * @time 16:54
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 */

use \yii\bootstrap\Html;

\app\assets\C3ChartAsset::register($this);

$this->title = 'Статистика рынка';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo $this->render('chartUsers');
echo Html::tag('br');
echo $this->render('chartJapa');

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

