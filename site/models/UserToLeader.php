<?php
/**
 * UserToLeader.php
 *
 * Created by PhpStorm.
 * @date 03.08.18
 * @time 13:03
 */

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * Class UserToLeader
 *
 * Отношние пользователей к лидерам
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $userId Идентификатор пользователя
 * @property int $leaderId Идентификатор пользователя лидера
 */
class UserToLeader extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['userId', 'leaderId'], 'required'],
            [
                'userId',
                'unique',
                'message' => Yii::t('app', 'This user already has leader record'),
                'when' => function () {
                    return $this->getIsNewRecord();
                }
            ],
            [
                ['userId', 'leaderId'],
                'exist',
                'targetAttribute' => 'id',
                'targetClass' => User::class,
                'message' => Yii::t('app', 'User should be created or active'),
                'filter' => ['<>', 'status', User::STATUS_BLOCKED],
            ],
        ]);
    }
}