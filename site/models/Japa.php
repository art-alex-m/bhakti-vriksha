<?php
/**
 * Japa.php
 *
 * Created by PhpStorm.
 * @date 06.08.18
 * @time 11:41
 */

namespace app\models;

use app\components\ActiveRecord;
use app\components\JapaStatBehavior;
use app\components\SerializableTrait;
use Yii;

/**
 * Class Japa
 *
 * Класс предоставляет возможности хранения статистки пользователей по чтению кругов мантры
 * Харе Кришна Харе Кришна Кришна Кришна Харе Харе \ Харе Рама Харе Рама Рама Рама Харе Харе
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property string $id Идетификатор записи
 * @property int $userId Идентификатор пользователя
 * @property int $number Количество кругов
 */
class Japa extends ActiveRecord implements \Serializable
{
    use SerializableTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['userId', 'number'],
                'filter',
                'filter' => 'strip_tags'
            ],
            [['userId', 'number'], 'required'],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            ['number', 'integer', 'min' => 1],
            [
                'createdAt',
                'safe',
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'number' => Yii::t('app', 'Number of circles'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            JapaStatBehavior::class,
        ]);
    }
}