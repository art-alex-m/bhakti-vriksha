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
use yii\behaviors\TimestampBehavior;
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
 */
class Statistics extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
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