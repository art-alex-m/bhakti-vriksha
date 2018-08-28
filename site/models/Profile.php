<?php
/**
 * Profile.php
 *
 * Created by PhpStorm.
 * @date 02.08.18
 * @time 15:22
 */

namespace app\models;

use app\components\GetUserTrait;
use app\components\ActiveRecord;
use app\components\SerializableTrait;
use Yii;

/**
 * Class Profile
 * Профиль личных данных пользователя
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $userId Идентификатор пользователя
 * @property string $lastName Фамилия
 * @property string $firstName Имя
 * @property string $parentName Отчество
 * @property string $phone Контактный телефон
 *
 * @property-read string $fullName Полное имя пользователя
 */
class Profile extends ActiveRecord implements \Serializable
{
    use GetUserTrait,
        SerializableTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['userId', 'lastName', 'firstName', 'parentName', 'phone'],
                'filter',
                'filter' => 'strip_tags'
            ],
            [['lastName', 'firstName', 'parentName', 'phone'], 'filter', 'filter' => 'trim'],
            [['userId', 'lastName', 'firstName', 'parentName', 'phone'], 'required'],
            [['lastName', 'firstName', 'parentName'], 'string', 'max' => 100],
            [
                'userId',
                'unique',
                'message' => Yii::t('app', 'This user already has profile'),
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            [
                'phone',
                'match',
                'pattern' => '~^(\+7|8)~u',
                'not' => true,
                'message' => Yii::t('app', 'Please use russian phone mask 712345...')
            ],
            [
                'phone',
                'match',
                'pattern' => '~^7[34589]\d+~u',
                'message' => Yii::t('app', '{attribute} should be valid Russian phone number')
            ],
            ['phone', 'string', 'length' => 11],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'userId' => Yii::t('app', 'User ID'),
            'lastName' => Yii::t('app', 'Last name'),
            'firstName' => Yii::t('app', 'First name'),
            'parentName' => Yii::t('app', 'Parent name'),
            'phone' => Yii::t('app', 'Phone number'),
            'fullName' => Yii::t('app', 'FIO'),
        ]);
    }

    /**
     * Возвращает строку с полным именем пользователя
     * @return string
     */
    public function getFullName()
    {
        $fio = [$this->lastName, $this->firstName, $this->parentName];
        return implode(' ', $fio);
    }
}