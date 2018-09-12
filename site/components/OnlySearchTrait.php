<?php
/**
 * OnlySearchTrait
 *
 * Created by PhpStorm.
 * @date 29.05.17
 * @time 16:56
 */

namespace app\components;

use yii\base\InvalidCallException;
use Yii;

/**
 * Class OnlySearchTrait
 * Добавляет в модель поведение "только для поиска"
 * @package app\components
 * @since 1.0.0
 */
trait OnlySearchTrait
{
    /**
     * Удаляет возможность сохранения модели
     *
     * @param bool $insert
     */
    public function beforeSave($insert)
    {
        throw new InvalidCallException(Yii::t(
            'app', 'This model {cls} only for search requests', [
                'cls' => static::class,
            ]
        ));
    }
}
