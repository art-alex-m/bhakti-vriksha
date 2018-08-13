<?php
/**
 * User.php
 *
 * Created by PhpStorm.
 * @date 02.08.18
 * @time 12:10
 */

namespace app\models;

use yii\base\NotSupportedException;
use app\components\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

/**
 * Class User
 *
 * Модель описывает свойства пользователя системы
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property-read int $id Идентификатор пользователя
 * @property-read string $username Логин пользователя в системе
 * @property string $passwordHash Хеш пароля пользователя
 * @property string $authKey Ключ авторизации
 * @property-write string $password Пароль
 * @property int $status Статус учетной записи
 *
 * @property-read Profile $profile Профиль пользователя
 * @property-read Residence $residence Город проживания пользователя
 * @property-read User $leader Лидер группы пользователя
 * @property-read string $residenceName Наименование города проживания пользователя
 * @property-read Japa[] $japa Список статистики по чтению кругов Харе Кришна Махамантры
 */
class User extends ActiveRecord implements IdentityInterface
{
    /// Статусы пользователя в системе
    const STATUS_NEW = 1;
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 80;

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'passwordHash' => Yii::t('app', 'Password hash'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Authorization key'),
            'status' => Yii::t('app', 'Status'),
            'residenceName' => Yii::t('app', 'City of residence'),
            'residence' => Yii::t('app', 'City of residence'),
            'profile' => Yii::t('app', 'User profile'),
            'leader' => Yii::t('app', 'Leader'),
            'japa' => Yii::t('app', 'Japa stat'),
        ]);
    }

    /**
     * Проверяет соответсвие пароля
     *
     * @param string $password Пароль для сравнения
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    /**
     * Создает хеш пароля для текущей записи пользователя
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Создает "remember me" идентификационный ключ
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Профиль пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['userId' => 'id']);
    }

    /**
     * Город проживания пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getResidence()
    {
        return $this->hasOne(Residence::class, ['userId' => 'id']);
    }

    /**
     * Возвращает имя города проживания пользователя
     * @return string
     */
    public function getResidenceName()
    {
        if ($this->residence instanceof Residence) {
            return $this->residence->title;
        }
        return '';
    }

    /**
     * Руководитель группы пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getLeader()
    {
        return $this->hasOne(User::class, ['id' => 'leaderId'])->via('userToLeader');
    }

    /**
     * Отношение пользователя к лидерам групп
     * @return \yii\db\ActiveQuery
     */
    public function getUserToLeader()
    {
        return $this->hasOne(UserToLeader::class, ['userId' => 'id']);
    }

    /**
     * Возвращает список записей статистики по чтению кругов Харе Кришна Махамантры
     * @return \yii\db\ActiveQuery
     */
    public function getJapa()
    {
        return $this->hasMany(Japa::class, ['userId' => 'id'])
            ->orderBy(['createdAt' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" метод требует реализации');
    }

    /**
     * Находит учетную запись пользователя по логину
     * @param string $username
     * @return null|static
     */
    public static function findByUserName($username)
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
}