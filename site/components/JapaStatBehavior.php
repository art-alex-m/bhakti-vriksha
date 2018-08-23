<?php
/**
 * JapaStatBehavior.php
 *
 * Created by PhpStorm.
 * @date 24.08.18
 * @time 10:50
 */

namespace app\components;

use app\models\Japa;
use app\models\Statistics;
use yii\base\Behavior;

/**
 * Class JapaStatBehavior
 *
 * Добавляет запись статистики при вводе новых кругов джапы
 *
 * @package app\components
 * @since 1.0.0
 */
class JapaStatBehavior extends Behavior
{
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            Japa::EVENT_AFTER_INSERT => 'addStatistics',
        ];
    }

    /**
     * Добавляет запись статистики ввода кругов
     * @param \yii\base\Event $event
     */
    public function addStatistics($event)
    {
        $stat = new Statistics([
            'userId' => $event->sender->userId,
            'type' => StatTypes::TYPE_CIRCLES_INPUT,
        ]);
        $stat->save();
    }
}