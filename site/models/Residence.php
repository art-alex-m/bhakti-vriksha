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
 * @property string $title Наименование города проживания
 */
class Residence extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['userId', 'title'],
                'filter',
                'filter' => 'strip_tags'
            ],
            ['title', 'filter', 'filter' => 'trim'],
            [['userId', 'title'], 'required'],
            ['title', 'string', 'length' => 100],
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
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
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
            'title' => Yii::t('app', 'City'),
        ]);
    }
}