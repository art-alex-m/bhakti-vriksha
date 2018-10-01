<?php
/**
 * chartJapa.php
 *
 * Диаграмма по количеству кругов джапы
 *
 * Created by PhpStorm.
 * @date 05.09.18
 * @time 13:55
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 */

use \yii\bootstrap\Html;

echo Html::tag('h3', 'Число повторений кругов');

$txt = <<<TXT
На этой странице вы можете видеть график суммарного количества кругов джапы, 
прочитанных всеми участниками проекта
TXT;

echo Html::tag('p', $txt);

echo \yii\bootstrap\Tabs::widget([
    'navType' => 'nav-pills',
    'renderTabContent' => false,
    'items' => [
        ['label' => 'За месяц', 'linkOptions' => ['id' => 'chart-japa-day'], 'active' => true],
        ['label' => 'За год', 'linkOptions' => ['id' => 'chart-japa-month']],
        ['label' => 'За 5 лет', 'linkOptions' => ['id' => 'chart-japa-year']],
    ],
]);

echo Html::tag('div', '', [
    'id' => 'chart-japa',
    'style' => [
        'margin-top' => '1em',
        'min-height' => '320px'
    ]
]);

$c3 = <<<JS
jQuery(function($) {
    let timeFormatter;    
    let chartConf = {
        bindto: "#chart-japa",      
        data: {
            type: 'line',
            xFormat: '%Y-%m-%d %H:%M:%S',
            json: [],
            order: null      
        },
        line: {
            step: {
                type: 'step-after'
            }
        },      
        axis: {
            x: {
                type: 'timeseries',
                tick: {
                    format: function(label) {
                        return timeFormatter(label);
                    }
                }
            },
            y: {
                tick: {
                    format: function (label) {
                        if (label % 1 === 0) {
                            return label;
                        }
                        return '';
                    }
                },
                padding: {
                    top: 0, 
                    bottom: 0
                }
            }
        },
        legend: {
            hide: true,
            show: false
        }
    };
    let chart;
    
    let loadForDays = function () {
        $.get({
            'url': '/c3-chart/japa-amount?period=day',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('day');
                data['type'] = 'area-step';
                data['colors'] = {
                    total: '#40ff00'                   
                };
                if (chart) {
                    chart = chart.destroy();
                }
                chart = c3.generate(chartConf);
                chart.load(data);
            }
        });
    };
    
    let loadForMonth = function () {
        $.get({
            'url': '/c3-chart/japa-amount?period=month',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('month');
                data['type'] = 'area-step';
                data['types'] = {
                    total: 'line'
                };
                data['colors'] = {
                    total: '#ff0000',
                    amount: '#0080ff',
                    previousTotal: '#4ce600'                  
                };
                data['keys']['value'] = ['previousTotal', 'amount', 'total'];
                if (chart) {
                    chart = chart.destroy();
                }
                chart = c3.generate(chartConf);
                chart.load(data);
                chart.groups([['amount', 'previousTotal']]);
                chart.legend.show(true);
            }
        });
    };
    
    let loadForYears = function () {
        $.get({
            'url': '/c3-chart/japa-amount?period=year',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('year');
                data['type'] = 'bar';
                data['types'] = {
                    total: 'line'
                };
                data['colors'] = {
                    total: '#c9c9c9'                 
                };
                data['keys']['value'] = ['previousTotal', 'amount', 'total'];
                if (chart) {
                    chart = chart.destroy();
                }
                chart = c3.generate(chartConf);
                chart.load(data);
                chart.groups([['amount', 'previousTotal']]);
                chart.legend.show(true);
            }
        });
    };
    
    $('#chart-japa-day').click(loadForDays);
    $('#chart-japa-month').click(loadForMonth);
    $('#chart-japa-year').click(loadForYears);

    setTimeout(function () {
        loadForDays();        
    }, 500);
});
JS;

$this->registerJs($c3, \yii\web\View::POS_END);