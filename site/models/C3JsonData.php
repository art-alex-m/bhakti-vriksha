<?php
/**
 * C3JsonData.php
 *
 * Created by PhpStorm.
 * @date 04.09.18
 * @time 10:14
 */

namespace app\models;

use yii\base\BaseObject;

/**
 * Class C3JsonData
 *
 * Представление данных в виде json для C3 диаграмм
 *
 * @package app\models
 * @since 1.0.0
 */
class C3JsonData extends BaseObject
{
    /** @var array Данные для отображения */
    public $json;
    /** @var array Ключи */
    public $keys;
    /** @var array Наименование для отображения в легенде диаграммы */
    public $names;
}