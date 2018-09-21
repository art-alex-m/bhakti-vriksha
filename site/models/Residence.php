<?php
/**
 * Residence.php
 *
 * Created by PhpStorm.
 * @date 03.08.18
 * @time 12:06
 */

namespace app\models;

use app\components\ActiveRecord;
use app\components\SerializableTrait;
use Yii;

/**
 * Class Residence
 *
 * Город проживания пользователя
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $userId Идентификатор пользователя
 * @property string $cityId Идентификатор города проживания
 */
class Residence extends ActiveRecord implements \Serializable
{
    use SerializableTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['userId', 'cityId'],
                'filter',
                'filter' => 'strip_tags'
            ],
            [['userId', 'cityId'], 'required'],
            [
                'userId',
                'unique',
                'message' => Yii::t('app', 'This user already has city of residence'),
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
                'filter' => ['not in', 'status', [User::STATUS_BLOCKED, User::STATUS_BLOCKED_USER]],
            ],
            [
                'cityId',
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => City::class,
                'message' => Yii::t('app', 'City should be created or active'),
                'filter' => ['=', 'status', City::STATUS_ACTIVE],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'userId' => Yii::t('app', 'User ID'),
            'cityId' => Yii::t('app', 'City'),
        ]);
    }
}