<?php
/**
 * UserBlockStatBehavior.php
 *
 * Created by PhpStorm.
 * @date 13.09.18
 * @time 18:13
 */

namespace app\components;

use app\controllers\UserController;
use app\models\Statistics;
use yii\base\Behavior;

/**
 * Class UserBlockStatBehavior
 *
 * Поведение, реализующее внесение статистики добровольной блокировки аккаунта
 *
 * @package app\components
 * @since 1.0.0
 */
class UserBlockStatBehavior extends Behavior
{
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            UserController::EVENT_ACCOUNT_SELF_BLOCK => 'addStatistics',
        ];
    }

    /**
     * Добавляет статистику блокировки аккаунта пользователя
     * @param Event $event
     */
    public function addStatistics($event)
    {
        $stat = new Statistics([
            'userId' => $event->context['user']->id,
            'type' => StatTypes::TYPE_ACCOUNT_BLOCK,
        ]);
        $stat->save();
    }
}