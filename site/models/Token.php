<?php
/**
 * Token.php
 *
 * Created by PhpStorm.
 * @date 06.08.18
 * @time 17:34
 */

namespace app\models;

use app\components\GetConfigParamTrait;
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
 * @property int $expiredAt Срок действия
 * @property string $hash Хешь токена
 *
 * @property-read bool $isValid Указывает действителен токен или нет
 */
class Token extends ActiveRecord
{
    use GetConfigParamTrait;

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
                'integer',
                'min' => time() + 1,
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
        ];
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
     * Фабричный метод для создания токена сброса пароля
     *
     * @param int $userId Идентификатор пользователя [[app\models\User]]
     * @return static
     * @throws \yii\base\Exception
     */
    public static function createPwdResetToken($userId)
    {
        return new static([
            'userId' => $userId,
            'type' => self::TYPE_PWD_RESET,
            'expiredAt' => time() + static::getConfigParam('pwdResetTokenLifeTime', 1),
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
        return new static([
            'userId' => $userId,
            'type' => self::TYPE_REG_CONFIRM,
            'expiredAt' => time() + static::getConfigParam('regConfirmTokenLifeTime', 1),
            'hash' => Yii::$app->security->generateRandomString(),
        ]);
    }
}