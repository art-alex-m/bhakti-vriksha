<?php
/**
 * Event.php
 *
 * Created by PhpStorm.
 * @date 20.08.18
 * @time 18:00
 */

namespace app\components;

/**
 * Class Event
 * @package app\components
 * @since 1.0.0
 */
class Event extends \yii\base\Event
{
    /** @var array|null Контекст, в котором произошло генерирование события */
    public $context;
}