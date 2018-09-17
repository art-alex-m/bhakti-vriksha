<?php
/**
 * Permissions.php
 *
 * Created by PhpStorm.
 * @date 07.09.18
 * @time 12:11
 */

namespace app\rbac;

use Yii;

/**
 * Class Permissions
 *
 * Список разрешений RBAC
 *
 * @package app\components
 * @since 1.0.0
 */
class Permissions
{
    const PERMISSION_ACTIVITY_VIEW = 'permission_activity_view'; /// просмотр действий пользователя
    const PERMISSION_GROUP_LIST = 'permission_group_list'; /// просмотр списка участников группы
    const PERMISSION_JAPA_LIST = 'permission_japa_list'; /// просмотр списка джапы с кнопками
    const PERMISSION_JAPA_CREATE = 'permission_japa_create'; /// создание записи количества кругов
    const PERMISSION_JAPA_UPDATE = 'permission_japa_update'; /// обновление количества кругов
    const PERMISSION_JAPA_VIEW = 'permission_japa_view'; /// просмотр списка джапы
    const PERMISSION_PROFILE_UPDATE = 'permission_profile_update'; /// обновление профиля
    const PERMISSION_PROFILE_VIEW = 'permission_profile_view'; /// просмотр профиля
    const PERMISSION_PROFILE_VIEW_GROUP = 'permission_profile_view_group'; /// просмотр профиля участника группы
    const PERMISSION_REGCODE_LIST = 'permission_regcode_list'; /// просмотр списка кодов регистрации
    const PERMISSION_REGCODE_CREATE = 'permission_regcode_create'; /// создание кода регистрации
    const PERMISSION_USERS_LIST = 'permission_users_list'; /// просмотр списка пользователей
    const PERMISSION_USER_ROLE_UPDATE = 'permission_user_role_update'; /// смена роли пользователя
    const PERMISSION_USER_STATUS_UPDATE = 'permission_user_status_update'; /// смена статуса пользователя
    const PERMISSION_USER_ROLE_UPD_GROUP = 'permission_user_role_update_group'; /// смена роли пользователя в группе

    /**
     * Возвращает список всех возможных прав доступа
     * @return array
     */
    public static function getPermissionsList()
    {
        static $list;
        if (is_null($list)) {
            $list = [
                self::PERMISSION_ACTIVITY_VIEW => Yii::t('app', 'Permission view activity'),
                self::PERMISSION_GROUP_LIST => Yii::t('app', 'Permission view group list'),
                self::PERMISSION_JAPA_LIST => Yii::t('app', 'Permission view japa list'),
                self::PERMISSION_JAPA_CREATE => Yii::t('app', 'Permission create japa entry'),
                self::PERMISSION_JAPA_UPDATE => Yii::t('app', 'Permission update japa entry'),
                self::PERMISSION_JAPA_VIEW => Yii::t('app', 'Permission view japa entry'),
                self::PERMISSION_PROFILE_UPDATE => Yii::t('app', 'Permission update own profile'),
                self::PERMISSION_PROFILE_VIEW => Yii::t('app', 'Permission view user profile'),
                self::PERMISSION_PROFILE_VIEW_GROUP =>
                    Yii::t('app', 'Permission view user profile in group'),
                self::PERMISSION_REGCODE_LIST =>
                    Yii::t('app', 'Permission view registration code list'),
                self::PERMISSION_REGCODE_CREATE =>
                    Yii::t('app', 'Permission create registration code'),
                self::PERMISSION_USERS_LIST => Yii::t('app', 'Permission view users list'),
                self::PERMISSION_USER_ROLE_UPDATE => Yii::t('app', 'Permission change user role'),
                self::PERMISSION_USER_STATUS_UPDATE =>
                    Yii::t('app', 'Permission change user status'),
                self::PERMISSION_USER_ROLE_UPD_GROUP =>
                    Yii::t('app', 'Permission change user role in group'),
            ];
        }
        return $list;
    }
}