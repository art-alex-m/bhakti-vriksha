<?php
/**
 * RbacSystemInit.php
 *
 * Created by PhpStorm.
 * @date 07.09.18
 * @time 20:21
 */

namespace app\rbac;

use yii\base\Model;
use Yii;

/**
 * Class RbacSystemInit
 *
 * Инициирует систему прав и разрешений
 *
 * @package app\models
 * @since 1.0.0
 */
class RbacSystemInit extends Model
{
    /** @var yii\rbac\ManagerInterface Компонент управления RBAC */
    public $auth;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->auth = Yii::$app->authManager;
    }

    /**
     * Запуск развертывания системы ролевого доступа
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function start()
    {
        $this->auth->removeAllPermissions();
        $this->auth->removeAllRules();

        Yii::$app->db->createCommand()
            ->truncateTable($this->auth->itemChildTable)
            ->execute();

        $this->createPermissions();
        $this->createRoles();
        $this->initRoles();
    }

    /**
     * Инициирует роли системы разрешениями и правилами
     * @throws \yii\base\Exception
     */
    protected function initRoles()
    {
        $this->initBvParticipant();
        $this->initGroupLeader();
        $this->initSectorCoordinator();
        $this->initDistrictCoordinator();
        $this->initMahareaCoordinator();
        $this->initCityCoordinator();
        $this->initRegionCoordinator();
        $this->initRussianCoordinator();
        $this->initSupervisor();
    }

    /**
     * Инициирует роль супер администратора
     * @throws \yii\base\Exception
     */
    public function initSupervisor()
    {
        $role = $this->auth->getRole(Roles::ROLE_SUPERVISOR);

        $permissions = [
            Permissions::PERMISSION_PROFILE_UPDATE,
            Permissions::PERMISSION_PROFILE_VIEW,
            Permissions::PERMISSION_REGCODE_LIST,
            Permissions::PERMISSION_REGCODE_CREATE,
            Permissions::PERMISSION_ACTIVITY_VIEW,
            Permissions::PERMISSION_USERS_LIST,
        ];

        foreach ($permissions as $name) {
            $permission = $this->auth->getPermission($name);
            $this->auth->addChild($role, $permission);
        }
    }

    /**
     * Инициирует роль координатора русскоязычной БВ
     * @throws \yii\base\Exception
     */
    public function initRussianCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_RUSSIAN_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль координатора региона
     * @throws \yii\base\Exception
     */
    public function initRegionCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_REGION_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль координатора города
     * @throws \yii\base\Exception
     */
    public function initCityCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_CITY_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль координатора махаокруга
     * @throws \yii\base\Exception
     */
    public function initMahareaCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_MAHAREA_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль координатора округа
     * @throws \yii\base\Exception
     */
    public function initDistrictCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_DISTRICT_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль координатора сектора
     * @throws \yii\base\Exception
     */
    public function initSectorCoordinator()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $role = $this->auth->getRole(Roles::ROLE_SECTOR_COORDINATOR);
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль слуги лидера группы
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    protected function initGroupLeader()
    {
        $baseRole = $this->auth->getRole(Roles::ROLE_BV_PARTICIPANT);
        $role = $this->auth->getRole(Roles::ROLE_GROUP_LEADER);
        $permissions = [
            Permissions::PERMISSION_PROFILE_VIEW_GROUP,
            Permissions::PERMISSION_JAPA_VIEW,
            Permissions::PERMISSION_REGCODE_LIST,
            Permissions::PERMISSION_REGCODE_CREATE,
            Permissions::PERMISSION_GROUP_LIST,
        ];
        $groupRule = new OnlyGroupRule();
        $this->auth->add($groupRule);
        $permission = $this->auth->getPermission(Permissions::PERMISSION_PROFILE_VIEW_GROUP);
        $permission->ruleName = $groupRule->name;
        $this->auth->update(Permissions::PERMISSION_PROFILE_VIEW_GROUP, $permission);
        $permissionA = $this->auth->getPermission(Permissions::PERMISSION_PROFILE_VIEW);
        $this->auth->addChild($permission, $permissionA);

        $permission = $this->auth->getPermission(Permissions::PERMISSION_JAPA_VIEW);
        $permission->ruleName = $groupRule->name;
        $this->auth->update(Permissions::PERMISSION_JAPA_VIEW, $permission);

        foreach ($permissions as $name) {
            $permission = $this->auth->getPermission($name);
            $this->auth->addChild($role, $permission);
        }
        $this->auth->addChild($role, $baseRole);
    }

    /**
     * Инициирует роль Участник БВ
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    protected function initBvParticipant()
    {
        $role = $this->auth->getRole(Roles::ROLE_BV_PARTICIPANT);
        $permissions = [
            Permissions::PERMISSION_ACTIVITY_VIEW,
            Permissions::PERMISSION_PROFILE_UPDATE,
            Permissions::PERMISSION_JAPA_LIST,
            Permissions::PERMISSION_JAPA_CREATE,
            Permissions::PERMISSION_JAPA_UPDATE,
        ];

        $ownJapa = new UpdateOwnJapaRule();
        $this->auth->add($ownJapa);
        $permission = $this->auth->getPermission(Permissions::PERMISSION_JAPA_UPDATE);
        $permission->ruleName = $ownJapa->name;
        $this->auth->update(Permissions::PERMISSION_JAPA_UPDATE, $permission);

        foreach ($permissions as $name) {
            $permission = $this->auth->getPermission($name);
            $this->auth->addChild($role, $permission);
        }
    }

    /**
     * Создает разрешения системы
     * @throws \Exception
     */
    protected function createPermissions()
    {
        $list = Permissions::getPermissionsList();
        foreach ($list as $name => $description) {
            $permission = $this->auth->createPermission($name);
            $permission->description = $description;
            $this->auth->add($permission);
        }
    }

    /**
     * Создает список ролей системы
     * Если роль уже создана, то пропускает
     * @throws \Exception
     */
    protected function createRoles()
    {
        $list = Roles::getRolesList();
        foreach ($list as $name => $description) {
            $role = $this->auth->getRole($name);
            if (!$role) {
                $role = $this->auth->createRole($name);
                $role->description = $description;
                $this->auth->add($role);
            }
        }
    }
}