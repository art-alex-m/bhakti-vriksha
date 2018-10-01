<?php
/**
 * chartUsers.php
 *
 * Диаграмма количества пользователей системы
 *
 * Created by PhpStorm.
 * @date 05.09.18
 * @time 13:53
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 */

use \yii\bootstrap\Html;

echo Html::tag('h3', 'Число участников рынка');

echo Html::tag('p', 'На этой странице вы можете видеть график числа участников рынка');

echo \yii\bootstrap\Tabs::widget([
    'navType' => 'nav-pills',
    'renderTabContent' => false,
    'items' => [
        ['label' => 'За месяц', 'linkOptions' => ['id' => 'chart-users-day'], 'active' => true],
        ['label' => 'За год', 'linkOptions' => ['id' => 'chart-users-month']],
        ['label' => 'За 5 лет', 'linkOptions' => ['id' => 'chart-users-year']],
    ],
]);

echo Html::tag('div', '', [
    'id' => 'chart-users',
    'style' => [
        'margin-top' => '1em',
        'min-height' => '320px',
    ]
]);

$c3 = <<<JS
jQuery(function($) {
    let timeFormatter;    
    let chartConf = {
        bindto: "#chart-users",      
        data: {
            type: 'line',
            xFormat: '%Y-%m-%d %H:%M:%S',
            json: []    
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
                },
                culling: {
                    max: 5
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
            'url': '/c3-chart/users-amount?period=day',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('day');
                data['type'] = 'area-step';
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
            'url': '/c3-chart/users-amount?period=month',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('month');               
                data['type'] = 'bar';
                if (chart) {
                    chart = chart.destroy();
                }
                chart = c3.generate(chartConf);
                chart.load(data);
            }
        });
    };
    
    let loadForYears = function () {
        $.get({
            'url': '/c3-chart/users-amount?period=year',
            'success': function(data) {
                timeFormatter = c3FormatBuilder('year');
                data['type'] = 'bar';                
                if (chart) {
                    chart = chart.destroy();
                }
                chart = c3.generate(chartConf);
                chart.load(data);
            }
        });
    };
    
    $('#chart-users-day').click(loadForDays);
    $('#chart-users-month').click(loadForMonth);
    $('#chart-users-year').click(loadForYears);

    setTimeout(function () {
        loadForDays();        
    }, 500);
});
JS;

$this->registerJs($c3, \yii\web\View::POS_END);