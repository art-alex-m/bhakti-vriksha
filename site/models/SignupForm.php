<?php
/**
 * SignupForm
 *
 * @date 14.08.2018
 * @time 12:10
 */

namespace app\models;

use app\rbac\Roles;
use yii\base\Model;
use Yii;

/**
 * Class SignupForm
 * Форма регистрации нового пользователя
 *
 * @package app\models
 * @since 1.0.0
 */
class SignupForm extends Model
{
    /** @var string Логин пользователя, адрес электронной почты */
    public $username;
    /** @var string Прароль пользователя */
    public $password;
    /** @var string Повтор пароля пользователя */
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'email', 'checkDNS' => true, 'enableIDN' => true],
            ['username', 'string', 'max' => 255],
            [
                'username',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app', 'This username address has already been taken'),
            ],
            [['password', 'confirmPassword'], 'required'],
            ['password', 'string', 'min' => 6],
            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'password',
                'operator' => '===',
                'message' =>
                    Yii::t('app', 'Confirmation and password should be the same'),
            ],
        ];
    }

    /**
     * Создает аккаунт нового пользователя
     * @return $this|User|null
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = $this->signupUser();
            if ($user) {
                return $user;
            }
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Email (login)'),
            'password' => Yii::t('app', 'Password'),
            'confirmPassword' => Yii::t('app', 'Password confirmation'),
        ];
    }

    /**
     * Создает аккаунт пользователя в системе
     * @return User|null
     * @throws \Exception
     */
    protected function signupUser()
    {
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole(Roles::ROLE_BV_PARTICIPANT);
            Yii::$app->authManager->assign($role, $user->id);
            return $user;
        }
        return null;
    }
}
