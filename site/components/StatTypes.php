<?php
/**
 * StatTypes.php
 *
 * Created by PhpStorm.
 * @date 13.08.18
 * @time 10:58
 */

namespace app\components;

use Yii;

/**
 * Class StatTypes
 *
 * Хранит перечисление типов действий пользователя в системе для
 * логирования статистики
 *
 * @package app\components
 * @since 1.0.0
 * @see \app\models\Statistics
 */
class StatTypes
{
    const TYPE_SYSTEM_LOGIN = 1; /// Вход в систему
    const TYPE_CIRCLES_INPUT = 2; /// Ввод кругов джапы
    const TYPE_ACCOUNT_BLOCK = 3; /// Блокировка аккаунта
    const TYPE_NEW_USER = 4; /// Регистрация нового пользователя

    /**
     * Возвращает список типов событий статистики
     * @return array
     */
    public static function getTypesList()
    {
        static $types;
        if (is_null($types)) {
            $types = [
                self::TYPE_SYSTEM_LOGIN => Yii::t('app', 'System login'),
                self::TYPE_CIRCLES_INPUT => Yii::t('app', 'Circles input'),
                self::TYPE_ACCOUNT_BLOCK => Yii::t('app', 'Account block'),
                self::TYPE_NEW_USER => Yii::t('app', 'New user'),
            ];
        }
        return $types;
    }
}