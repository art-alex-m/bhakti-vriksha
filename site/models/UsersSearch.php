<?php
/**
 * UsersSearch.php
 *
 * Created by PhpStorm.
 * @date 11.09.18
 * @time 10:45
 */

namespace app\models;

use app\components\OnlySearchTrait;
use app\components\SearchTrait;
use app\rbac\Roles;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class UsersSearch
 *
 * Формирует провайдер данных по пользователям согласно запросу
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property-read string $statusName Наименование статуса модели
 * @property-read array $rolesNames Список наименований ролей пользователя
 */
class UsersSearch extends User
{
    use SearchTrait,
        OnlySearchTrait;

    /**
     * Формирует провайдер данных для отображения в гриде
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;

        $query = static::find()
            ->alias('u')
            ->joinWith('profile')
            ->leftJoin(['auth' => $auth->assignmentTable], 'u.id = cast(auth.user_id as integer)');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['createdAt' => SORT_DESC],
                'attributes' => $this->getOrderAttributes(),
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['=', 'status', $this->status]);
        $query->andFilterWhere(['~*', 'username', $this->username]);
        $query->andFilterWhere(['=', 'auth.item_name', $this->getExplicit('role')]);
        $query->andFilterWhere([
            '~*',
            'profile.firstName',
            $this->getExplicit('profile.firstName')
        ]);
        $query->andFilterWhere(['~*', 'profile.lastName', $this->getExplicit('profile.lastName')]);
        $query->andFilterWhere([
            '~*',
            'profile.parentName',
            $this->getExplicit('profile.parentName')
        ]);
        $query->andFilterWhere(['~*', 'profile.phone', $this->getExplicit('profile.phone')]);

        return $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer', 'min' => 1],
            ['username', 'string'],
            ['status', 'in', 'range' => array_keys(static::getStatusList())],
            ['role', 'in', 'range' => array_keys(Roles::getRolesList())],
            [['profile.firstName', 'profile.lastName', 'profile.parentName'], 'string'],
            ['profile.phone', 'match', 'pattern' => '~^\d+$~'],
        ];
    }

    /**
     * Возвращает наименование статуса модели
     * @param User $user
     * @return int|string
     */
    public function getStatusName()
    {
        $status = $this->status;
        $list = static::getStatusList();
        if (isset($list[$status])) {
            return $list[$status];
        }
        return $status;
    }

    /**
     * Возвращает список наименований ролей пользователя
     * @return array
     */
    public function getRolesNames()
    {
        $list = Roles::getRolesList();
        $roles = ArrayHelper::map($this->roles, 'name', function ($role) use ($list) {
            return isset($list[$role->name]) ? $list[$role->name] : $role->name;
        });
        return $roles;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return User::tableName();
    }

    /**
     * Возвращает настройки атрибутов сортировки
     * @return array
     */
    protected function getOrderAttributes()
    {
        return [
            'id',
            'createdAt',
            'status',
            'username',
            'role' => [
                'asc' => ['auth.item_name' => SORT_ASC],
                'desc' => ['auth.item_name' => SORT_DESC],
            ],
            'profile.firstName',
            'profile.lastName',
            'profile.parentName',
            'profile.phone',
        ];
    }
}