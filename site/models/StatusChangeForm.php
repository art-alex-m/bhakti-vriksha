<?php
/**
 * StatusChangeForm.php
 *
 * Created by PhpStorm.
 * @date 13.09.18
 * @time 10:09
 */

namespace app\models;

use yii\base\Model;

/**
 * Class StatusChangeForm
 *
 * Реализует сценарий изменения статуса учетной записи пользователя
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property-read array $availableStatus Доступные статусы для присвоения
 */
class StatusChangeForm extends Model
{
    /** @var int Идентификатор пользователя */
    public $id;
    /** @var int Статус учетной записи пользователя */
    public $status;
    /** @var User|null Модель пользователя, которому присваивают роли */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'id'], 'required'],
            [['status', 'id'], 'integer'],
            [
                'id',
                'exist',
                'targetClass' => User::class,
            ],
            ['status', 'in', 'range' => array_keys($this->getAvailableStatus())],
        ];
    }

    /**
     * Устанавливает статус по умолчанию
     */
    public function setDefaultStatus()
    {
        if (is_null($this->status)) {
            $user = $this->getUser();
            if ($user) {
                $this->status = $user->status;
            }
        }
    }

    /**
     * Возвращает список доступных статусов
     * @return array
     */
    public function getAvailableStatus()
    {
        $list = User::getStatusList();
        unset($list[User::STATUS_BLOCKED_USER]);
        return $list;
    }

    /**
     * Изменяет статус пользователя
     * @return bool
     */
    public function change()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        $user->status = $this->status;
        if (!$user->save()) {
            $this->addError('status', reset($user->getFirstErrors()));
            return false;
        }

        return true;
    }

    /**
     * Возвращает модель пользователя по идентификатору
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