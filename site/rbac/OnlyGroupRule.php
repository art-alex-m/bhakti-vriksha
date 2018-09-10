<?php
/**
 * OnlyGroupRule.php
 *
 * Created by PhpStorm.
 * @date 08.09.18
 * @time 21:35
 */

namespace app\rbac;

use app\models\UserToLeader;
use yii\db\Query;
use yii\rbac\Rule;

/**
 * Class OnlyGroupRule
 *
 * Проверяет, что лидер просматривает данные пользователей своей группы
 *
 * @package app\rbac
 * @since 1.0.0
 */
class OnlyGroupRule extends Rule
{
    public $name = 'OnlyGroup';

    /**
     * {@inheritdoc}
     */
    public function execute($userId, $item, $params)
    {
        $leaderId = (new Query())
            ->select('leaderId')
            ->from(UserToLeader::tableName())
            ->where(['=', 'userId', $params['userId']])
            ->scalar();

        return $userId == $leaderId;
    }
}