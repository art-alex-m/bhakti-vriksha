<?php
/**
 * RoleChangeForm.php
 *
 * Created by PhpStorm.
 * @date 12.09.18
 * @time 9:21
 */

namespace app\models;

use app\components\GetAuthUserTrait;
use app\rbac\Roles;
use yii\base\Model;
use Yii;

/**
 * Class RoleChangeForm
 *
 * Модель для смены роли пользователя
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property-read User|null $user Модель пользователя системы
 */
class RoleChangeForm extends Model
{
    use GetAuthUserTrait;

    /** @var int Идентификатор пользователя */
    public $id;
    /** @var string[] Список имен ролей пользователя */
    public $roles;

    /** @var User|null Модель пользователя, которому присваивают роли */
    protected $user;
    /** @var array|null Доступные для присвоения роли пользователя */
    protected $availableRoles;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['roles', 'required'],
            ['roles', 'each', 'rule' => ['in', 'range' => array_keys(Roles::getRolesList())]],
            ['roles', 'validateMinRole'],
            [
                'id',
                'exist',
                'targetClass' => User::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'roles' => Yii::t('app', 'Roles'),
        ];
    }

    /**
     * Присваивает роли модели пользователя
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function assign()
    {
        if (!$this->validate()) {
            return false;
        }

        $auth = Yii::$app->authManager;

        $available = $this->getAvailableRoles();
        $roles = $auth->getRolesByUser($this->id);
        foreach ($roles as $role) {
            if (!isset($available[$role->name])) {
                $this->roles[] = $role->name;
            }
        }

        $auth->revokeAll($this->id);

        foreach ($this->roles as $name) {
            $role = $auth->getRole($name);
            $auth->assign($role, $this->id);
        }

        return true;
    }

    /**
     * Проверяет роли для присвоения
     *
     * @param string $attribute
     * @throws \Throwable
     */
    public function validateMinRole($attribute)
    {
        $roles = $this->getAvailableRoles();
        $diff = array_diff($this->$attribute, array_keys($roles));
        if (count($diff) > 0) {
            $this->addError($attribute, Yii::t('app',
                'The role "{role}" is not available for assignment with your permissions',
                ['role' => $roles[$diff[0]]]
            ));
        }
    }

    /**
     * Список доступных ролей для присвоения пользователю
     * @return array
     * @throws \Throwable
     */
    public function getAvailableRoles()
    {
        if (is_null($this->availableRoles)) {
            $user = $this->getAuthUser();
            $range = Roles::getRolesRange();
            $maxRole = Roles::ROLE_BV_PARTICIPANT;
            foreach ($user->roles as $role) {
                $name = $role->name;
                if ($range[$maxRole] < $range[$name]) {
                    $maxRole = $name;
                }
            }
            $this->availableRoles = array_filter(
                Roles::getRolesList(),
                function ($key) use ($maxRole, $range) {
                    return $range[$maxRole] >= $range[$key];
                },
                ARRAY_FILTER_USE_KEY
            );
        }
        return $this->availableRoles;
    }

    /**
     * Возвращает модель пользвателя по идентификатору
     * @return User|null
     */
    public function getUser()
    {
        if (!$this->user instanceof User) {
            $this->user = User::findOne($this->id);
        }
        return $this->user;
    }
}