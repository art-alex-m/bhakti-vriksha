<?php
/**
 * LoginStatBehavior.php
 *
 * Created by PhpStorm.
 * @date 21.08.18
 * @time 10:53
 */

namespace app\components;

use app\models\Statistics;
use yii\base\Behavior;
use yii\web\UserEvent;

/**
 * Class LoginStatBehavior
 *
 * Поведение создания записи статистики при идентификации пользователя
 *
 * @package app\components
 * @since 1.0.0
 */
class LoginStatBehavior extends Behavior
{
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'addLoginStatistics',
            User::EVENT_AFTER_LOGOUT => 'addLogoutStatistics',
        ];
    }

    /**
     * Добавляет запись статистики успешного входа в систему
     * @param UserEvent $event
     */
    public function addLoginStatistics($event)
    {
        $stat = new Statistics([
            'userId' => $event->identity->getId(),
            'type' => StatTypes::TYPE_SYSTEM_LOGIN,
        ]);
        $stat->save();
    }

    /**
     * Добавляет запись статистики выхода из системы
     * @param UserEvent $event
     */
    public function addLogoutStatistics($event)
    {
        $stat = new Statistics([
            'userId' => $event->identity->getId(),
            'type' => StatTypes::TYPE_SYSTEM_LOGOUT,
        ]);
        $stat->save();
    }
}