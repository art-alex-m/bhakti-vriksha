<?php
/**
 * C3ChartAsset.php
 *
 * Created by PhpStorm.
 * @date 03.09.18
 * @time 16:59
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class C3ChartAsset
 * Скрипты для прорисовки диаграмм
 *
 * @package app\assets
 * @since 1.0.0
 */
class C3ChartAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'd3/d3.min.js',
        'c3/c3.min.js',
    ];

    public $css = [
        'c3/c3.min.css',
    ];
}