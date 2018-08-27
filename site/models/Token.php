<?php
/**
 * Token.php
 *
 * Created by PhpStorm.
 * @date 06.08.18
 * @time 17:34
 */

namespace app\models;

use app\components\DbTime;
use app\components\GetConfigParamTrait;
use app\components\GetDbTimestampTrait;
use app\components\GetUserTrait;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class Token
 *
 * Реализует функционал различных подтверждений через токены
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $id Идентификатор токена
 * @property int $userId Идентификатор пользователя
 * @property int $type Тип токена
 * @property string $expiredAt Срок действия
 * @property string $hash Хешь токена
 *
 * @property-read bool $isValid Указывает действителен токен или нет
 * @property-read \DateTime $expiredAsDateTime Срок действия токена как DateTime
 */
class Token extends ActiveRecord
{
    use GetUserTrait,
        GetConfigParamTrait,
        GetDbTimestampTrait;

    const TYPE_PWD_RESET = 1; /// токен сброса пароля
    const TYPE_REG_CONFIRM = 2; /// токен подтверждения регистрации

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'type', 'expiredAt'], 'required'],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            ['type', 'in', 'range' => [self::TYPE_PWD_RESET, self::TYPE_REG_CONFIRM]],
            [
                ['hash', 'expiredAt'],
                'safe',
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
            [
                'expiredAt',
                'greaterThenNow',
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
        ];
    }

    /**
     * Проверяет что срок действия токена в будущем
     * @param string $attribute
     * @param array $params
     */
    public function greaterThenNow($attribute, $params)
    {
        $time = strtotime($this->$attribute);
        if ($time <= time()) {
            $this->addError($attribute,
                Yii::t('app', 'Token expired time should be greater then now'));
        }
    }

    /**
     * Проверяет действительность токена
     * @return bool
     */
    public function getIsValid()
    {
        if ($this->getIsNewRecord()) {
            return false;
        }
        return strtotime($this->expiredAt) > time();
    }

    /**
     * Возвращает представление время действия токена в виде объекта DateTime
     * @return bool|\DateTime
     */
    public function getExpiredAsDateTime()
    {
        $dObj = new DbTime($this->expiredAt);
        return $dObj;
    }

    /**
     * Преобразование в строку
     * @return string
     */
    public function __toString()
    {
        return $this->hash;
    }

    /**
     * Фабричный метод для создания токена сброса пароля
     *
     * @param int $userId Идентификатор пользователя [[app\models\User]]
     * @return static
     * @throws \yii\base\Exception
     */
    public static function createPwdResetToken($userId)
    {
        $time = microtime(true) + static::getConfigParam('pwdResetTokenLifeTime', 1);
        return new static([
            'userId' => $userId,
            'type' => self::TYPE_PWD_RESET,
            'expiredAt' => (string)static::getDbTimestamp($time),
            'hash' => Yii::$app->security->generateRandomString(48),
        ]);
    }

    /**
     * Фабричный метод для создания токена подтверждения регистрации
     *
     * @param int $userId Идентификатор пользователя [[app\models\User]]
     * @return static
     * @throws \yii\base\Exception
     */
    public static function createRegConfirmToken($userId)
    {
        $time = microtime(true) + static::getConfigParam('regConfirmTokenLifeTime', 1);
        return new static([
            'userId' => $userId,
            'type' => self::TYPE_REG_CONFIRM,
            'expiredAt' => (string)static::getDbTimestamp($time),
            'hash' => Yii::$app->security->generateRandomString(),
        ]);
    }
}