<?php
/**
 * Statistics.php
 *
 * Created by PhpStorm.
 * @date 13.08.18
 * @time 10:54
 */

namespace app\models;

use app\components\StatTypes;
use app\components\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class Statistics
 *
 * Статистика действий пользователя в системе
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property string $id Идентификатор записи
 * @property int $userId Идентификатор пользователя
 * @property string $createdAt Время события
 * @property int $type Тип события
 *
 * @property-read string|int $label Наименование типа действия
 */
class Statistics extends ActiveRecord
{
    /**
     * Возвращает наименование типа действия пользователя
     * @return int|string
     */
    public function getLabel()
    {
        $types = StatTypes::getTypesList();
        if (isset($types[$this->type])) {
            return $types[$this->type];
        }
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'createdAt' => Yii::t('app', 'Created at'),
            'type' => Yii::t('app', 'Statistics type'),
            'label' => Yii::t('app', 'Label'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'type'], 'required'],
            [
                'userId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
            [
                'createdAt',
                'safe',
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
            ['type', 'in', 'range' => array_keys(StatTypes::getTypesList())],
        ];
    }
}