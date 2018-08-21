<?php
/**
 * Class ResetPasswordForm
 *
 * @date 21,08,2018
 * @time 16:35
 */

namespace app\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use Yii;

/**
 * Class ResetPasswordForm
 * Форма сброса пароля пользователя
 * @package app\models
 */
class PwdResetForm extends Model
{
    /** @var string Новый пароль пользователя */
    public $password;
    /** @var string Подтверждение пароля */
    public $confirmPassword;
    /** @var \app\models\User */
    protected $user;
    /** @var Token */
    protected $token;
    /** @var string */
    protected $tokenHash;

    /**
     * Конструктор
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(
                Yii::t('app', 'Password reset token cannot be blank'));
        }
        $this->tokenHash = $token;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->token = $this->findToken($this->tokenHash);
        if ($this->token instanceof Token) {
            if ($this->token->isValid) {
                $this->user = $this->token->user;
            } else {
                $this->token->delete();
            }
        }

        if (!$this->user) {
            throw new InvalidArgumentException(Yii::t('app', 'Wrong password reset token'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
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
     * Сбрасывает пароль пользователя
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function reset()
    {
        if ($this->validate()) {
            $user = $this->user;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $this->token->delete();
            return $user->save(false);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'confirmPassword' => Yii::t('app', 'Password confirmation'),
        ];
    }

    /**
     * Находит модель токена
     *
     * @param string $tkn
     * @return Token|array|null|\yii\db\ActiveRecord
     */
    protected function findToken($tkn)
    {
        $token = Token::find()
            ->andWhere(['=', 'hash', $tkn])
            ->andWhere(['=', 'type', Token::TYPE_PWD_RESET])
            ->with('user')
            ->one();

        return $token;
    }
}
