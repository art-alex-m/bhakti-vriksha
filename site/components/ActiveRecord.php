<?php
/**
 * ActiveRecord.php
 *
 * Created by PhpStorm.
 * @date 02.08.18
 * @time 15:47
 */

namespace app\components;

use Yii;

/**
 * Class ActiveRecord
 *
 * Реализует общие схемы поведения для моделей
 *
 * @package app\components
 * @since 1.0.0
 *
 * @property int $updatedAt Время последнего обновления
 * @property int $createdAt Время создания
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'createdAt' => Yii::t('app', 'Created at'),
            'updatedAt' => Yii::t('app', 'Updated at'),
        ];
    }
}