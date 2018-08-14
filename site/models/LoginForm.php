<?php
/**
 * LoginForm.php
 *
 * @date 14.08.2018
 * @time 14:03
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * Реализует логики идентификации пользователя
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property-read User|null|false $user Пользователь системы
 */
class LoginForm extends Model
{
    /** @var string Логин пользователя */
    public $username;
    /** @var string Пароль пользователя */
    public $password;
    /** @var bool Флаг запоминания авторизации пользователя */
    public $rememberMe = true;
    /** @var int Время на которое следует запомнить пользователя */
    public $rememberTime = 3600 * 24 * 30;
    /** @var User|null|false Модель пользователя в системе */
    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Проверяет соответствие пароля пользователя
     *
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or password'));
            }
        }
    }

    /**
     * Идентифицирует пользователя по логину и паролю
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),
                $this->rememberMe ? $this->rememberTime : 0);
        }
        return false;
    }

    /**
     * Определяет пользователя по логину [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
        ];
    }
}
