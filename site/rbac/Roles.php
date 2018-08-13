<?php
/**
 * Roles.php
 *
 * Created by PhpStorm.
 * @date 07.09.18
 * @time 8:20
 */

namespace app\rbac;

use Yii;

/**
 * Class Roles
 *
 * Список ролей RBAC пользователей системы
 *
 * @package app\components
 * @since 1.0.0
 */
class Roles
{
    const ROLE_SUPERVISOR = 'supervisor'; /// Администратор системы
    const ROLE_BV_PARTICIPANT = 'bv_participant'; /// Участник БВ
    const ROLE_GROUP_LEADER = 'group_leader'; /// Слуга лидер группы
    const ROLE_SECTOR_COORDINATOR = 'sector_coordinator'; /// Координатор сектора
    const ROLE_DISTRICT_COORDINATOR = 'district_coordinator'; /// Координатор округа
    const ROLE_MAHAREA_COORDINATOR = 'mahaarea_coordinator'; /// Координатор маха округа
    const ROLE_CITY_COORDINATOR = 'city_coordinator'; /// Координатор города
    const ROLE_REGION_COORDINATOR = 'region_coordinator'; /// Координатор региона
    const ROLE_RUSSIAN_COORDINATOR = 'russian_bv_coordinator'; /// Координатор русскоязычной БВ

    /**
     * Возвращает список ролей системы
     * @return array
     */
    public static function getRolesList()
    {
        static $roles;
        if (is_null($roles)) {
            $roles = [
                self::ROLE_SUPERVISOR => Yii::t('app', 'Super administrator'),
                self::ROLE_BV_PARTICIPANT => Yii::t('app', 'BV participant'),
                self::ROLE_GROUP_LEADER => Yii::t('app', 'The leader of the group'),
                self::ROLE_SECTOR_COORDINATOR => Yii::t('app', 'The coordinator of the sector'),
                self::ROLE_DISTRICT_COORDINATOR => Yii::t('app', 'The coordinator of the district'),
                self::ROLE_MAHAREA_COORDINATOR => Yii::t('app', 'The coordinator of the area'),
                self::ROLE_CITY_COORDINATOR => Yii::t('app', 'The coordinator of the city'),
                self::ROLE_REGION_COORDINATOR => Yii::t('app', 'The coordinator of the region'),
                self::ROLE_RUSSIAN_COORDINATOR => Yii::t('app', 'Coordinator of Russian BV'),
            ];
        }
        return $roles;
    }

    /**
     * Возвращает список ролей пользователей по рангу
     * @return array
     */
    public static function getRolesRange()
    {
        static $roles;
        if (is_null($roles)) {
            $roles = [
                self::ROLE_BV_PARTICIPANT => 900,
                self::ROLE_GROUP_LEADER => 800,
                self::ROLE_SECTOR_COORDINATOR => 700,
                self::ROLE_DISTRICT_COORDINATOR => 600,
                self::ROLE_MAHAREA_COORDINATOR => 500,
                self::ROLE_CITY_COORDINATOR => 200,
                self::ROLE_REGION_COORDINATOR => 100,
                self::ROLE_RUSSIAN_COORDINATOR => 50,
                self::ROLE_SUPERVISOR => 10,
            ];
        }
        return $roles;
    }
}