<?php
/**
 * RegistrationCode.php
 *
 * Created by PhpStorm.
 * @date 08.08.18
 * @time 16:20
 */

namespace app\models;

use app\components\GetConfigParamTrait;
use app\components\GetDbTimestampTrait;
use app\components\SerializableTrait;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

/**
 * Class RegistrationCode
 *
 * Единовременные коды регистрации для пользователей
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $userId Идентификатор лидера группы
 * @property int $code Код регистрации
 * @property string $expiredAt Время действия кода
 *
 * @property-read bool $isValid Проверяет действительность кода регистрации
 */
class RegistrationCode extends ActiveRecord implements \Serializable
{
    use GetDbTimestampTrait,
        GetConfigParamTrait,
        SerializableTrait;

    const SCENARIO_SEARCH = 'search';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'code', 'expiredAt'], 'required'],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            [
                'code',
                'unique',
                'except' => self::SCENARIO_SEARCH,
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
            ['code', 'integer', 'on' => self::SCENARIO_SEARCH],
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
                Yii::t('app', 'Registration code expired time should be greater then now'));
        }
    }

    /**
     * Проверяет действительность кода регистрации
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * Фабричный метод. Создает код регистрации пользователя
     *
     * @param int $userId Идентификатор пользователя-лидера
     * @param int $length Длина кода регистрации. По-умолчанию 4
     * @return static
     */
    public static function create($userId, $length = 4)
    {
        $time = microtime(true) + static::getConfigParam('regCodeLifeTime', 1);
        return new static([
            'userId' => $userId,
            'expiredAt' => (string)static::getDbTimestamp($time),
            'code' => static::generateCode($length),
        ]);
    }

    /**
     * Очищает таблицу от просроченных кодов регистрации
     * @return int
     * @throws \yii\db\Exception
     */
    public static function clearExpired()
    {
        return Yii::$app->db->createCommand()
            ->delete(static::tableName(), ['<', 'expiredAt', new Expression('NOW()')])
            ->execute();
    }

    /**
     * Осуществляет поиск кода регистрации по идентификатору
     * @param int $code
     * @return null|static
     */
    public static function findByCode($code)
    {
        $model = new static(['scenario' => self::SCENARIO_SEARCH]);
        $model->code = $code;
        if ($model->validate('code')) {
            return static::findOne($model->code);
        }
        return $model;
    }

    /**
     * Создает код регистрации
     *
     * @param int $length Длина кода регистрации
     * @return string
     */
    protected static function generateCode($length)
    {
        $code = '';
        while (--$length >= 0) {
            $code .= (string)rand(0, 9);
        }
        return $code;
    }
}