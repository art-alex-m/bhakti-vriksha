<?php
/**
 * GetUserTrait.php
 *
 * Created by PhpStorm.
 * @date 02.08.18
 * @time 15:35
 */

namespace app\components;

use \app\models\User;

/**
 * Trait GetUserTrait
 *
 * Трейт реализует функционал получения связанной модели пользователя
 *
 * @package app\components
 * @since 1.0.0
 *
 * @property-read User $user
 */
trait GetUserTrait
{
    /**
     * Возвращает объект связанного класса пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }
}