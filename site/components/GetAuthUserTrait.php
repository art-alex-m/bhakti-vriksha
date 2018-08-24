<?php
/**
 * GetAuthUserTrait.php
 *
 * Created by PhpStorm.
 * @date 23.08.18
 * @time 16:12
 */

namespace app\components;

/**
 * Trait GetAuthUserTrait
 * Возвращает модель авторизованного пользователя
 *
 * @package app\components
 * @since 1.0.0
 * @property-read \app\models\User|null $authUser
 */
trait GetAuthUserTrait
{
    /**
     * Возвращает модель авторизованного пользователя
     *
     * @param bool $autoRenew
     * @return \app\models\User|null|\yii\web\IdentityInterface
     * @throws \Throwable
     */
    public function getAuthUser($autoRenew = false)
    {
        return \Yii::$app->getUser()->getIdentity($autoRenew);
    }

}