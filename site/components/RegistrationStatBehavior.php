<?php
/**
 * RegistrationStatBehavior.php
 *
 * Created by PhpStorm.
 * @date 20.08.18
 * @time 18:13
 */

namespace app\components;

use app\controllers\RegistrationController;
use app\models\Statistics;
use yii\base\Behavior;

/**
 * Class RegistrationStatBehavior
 *
 * Поведение, реализующее внесение статистики регистрации нового пользователя
 *
 * @package app\components
 * @since 1.0.0
 */
class RegistrationStatBehavior extends Behavior
{
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            RegistrationController::EVENT_AFTER_REGISTRATION => 'addStatistics',
        ];
    }

    /**
     * Добавляет статистику регистрации нового пользователя
     * @param Event $event
     */
    public function addStatistics($event)
    {
        $stat = new Statistics([
            'userId' => $event->context['user']->id,
            'type' => StatTypes::TYPE_NEW_USER,
        ]);
        $stat->save();
    }
}