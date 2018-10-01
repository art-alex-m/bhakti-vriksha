<?php
/**
 * GetReturnUriHelper.php
 *
 * Created by PhpStorm.
 * @date 01.10.18
 * @time 15:44
 */

namespace app\components;

use app\rbac\Permissions;
use Yii;

/**
 * Class GetReturnUriHelper
 *
 * Возвращает uri редиректа в зависимости от статуса пользователя
 *
 * @package app\components
 * @since 1.1.0
 */
class GetReturnUriHelper
{
    /**
     * Возвращает uri редиректа в зависимости от роли пользователя
     * @param \yii\web\User|null $user
     * @return array|string
     */
    public static function getUri(\yii\web\User $user = null)
    {
        $uri = Yii::$app->defaultRoute;
        if (null == $user) {
            $user = Yii::$app->user;
        }
        if (!$user->isGuest) {
            if ($user->can(Permissions::PERMISSION_USERS_LIST)) {
                $uri = ['/user/'];
            } elseif ($user->can(Permissions::PERMISSION_JAPA_LIST)) {
                $uri = ['/japa/'];
            } else {
                $uri = ['/market/'];
            }
        }
        return $uri;
    }
}