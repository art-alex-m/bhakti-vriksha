<?php
/**
 * TimestampBehavior.php
 *
 * Created by PhpStorm.
 * @date 19.08.18
 * @time 11:37
 */

namespace app\components;

/**
 * Class TimestampBehavior
 *
 * Класс уточняющий поведение [[\yii\behaviors\TimestampBehavior]] для нужд проекта
 *
 * @package app\components
 * @since 1.0.0
 */
class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /** @var string Аттрибут модели для времени создания */
    public $createdAtAttribute = 'createdAt';
    /** @var string Аттрибут модели для времени последнего обновления */
    public $updatedAtAttribute = 'updatedAt';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (is_null($this->value)) {
            $this->value = function () {
                return new DbTime();
            };
        }
    }
}