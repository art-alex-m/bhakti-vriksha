<?php
/**
 * UpdateOwnProfileRule.php
 *
 * Created by PhpStorm.
 * @date 01.10.18
 * @time 13:50
 */

namespace app\rbac;

use yii\rbac\Rule;

/**
 * Class UpdateOwnProfileRule
 *
 * Фильтрует запросы на обновление только собственного профиля
 *
 * @package app\rbac
 * @since 1.1.0
 */
class UpdateOwnProfileRule extends Rule
{
    public $name = 'UpdateOwnProfile';

    /**
     * {@inheritdoc}
     */
    public function execute($userId, $item, $params)
    {
        return isset($params['userId']) && $params['userId'] == $userId;
    }
}