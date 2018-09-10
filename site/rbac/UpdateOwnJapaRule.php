<?php
/**
 * UpdateOwnJapaRule.php
 *
 * Created by PhpStorm.
 * @date 08.09.18
 * @time 19:49
 */

namespace app\rbac;

use app\models\Japa;
use yii\db\Query;
use yii\rbac\Rule;

/**
 * Class UpdateOwnJapaRule
 *
 * Фильтрует запросы на обновление только собственных записей кругов джапы
 *
 * @package app\rbac
 * @since 1.0.0
 */
class UpdateOwnJapaRule extends Rule
{
    public $name = 'UpdateOwnJapa';

    /**
     * {@inheritdoc}
     */
    public function execute($userId, $item, $params)
    {
        $japaOwnerId = (new Query())
            ->select('userId')
            ->from(Japa::tableName())
            ->where(['=', 'id', $params['japaId']])
            ->scalar();

        return $japaOwnerId == $userId;
    }
}