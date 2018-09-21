<?php
/**
 * GetStatusNameTrait.php
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 15:57
 */

namespace app\components;

/**
 * Trait GetStatusNameTrait
 *
 * Возвращает наименование статуса модели
 * NOTE: У модели должен быть атрибут status
 *
 * @package app\components
 * @since 1.0.0
 *
 * @property-read string $statusName Наименование статуса модели
 */
trait GetStatusNameTrait
{
    /**
     * Список статусов модели
     * @return array
     */
    abstract static function getStatusList();

    /**
     * Возвращает наименование статуса модели
     * @param User $user
     * @return int|string
     */
    public function getStatusName()
    {
        $status = $this->status;
        $list = static::getStatusList();
        if (isset($list[$status])) {
            return $list[$status];
        }
        return $status;
    }
}