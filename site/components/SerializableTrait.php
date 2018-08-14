<?php
/**
 * SerializableTrait.php
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 13:56
 */

namespace app\components;

use yii\helpers\Json;

/**
 * Trait SerializableTrait
 *
 * Сериализует AR объекты
 *
 * @package app\components
 * @since 1.0.0
 */
trait SerializableTrait
{
    /**
     * Сериализует представление объекта
     * @return string
     */
    public function serialize()
    {
        $data = array_filter($this->getAttributes());
        $data['isNewRecord'] = $this->getIsNewRecord();
        return Json::encode($data);
    }

    /**
     * Возвращает состояние сериализованного объекта
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = Json::decode($serialized);
        $this->setAttributes($data, false);
        if (isset($data['isNewRecord'])) {
            $this->setIsNewRecord($data['isNewRecord']);
        }
    }
}