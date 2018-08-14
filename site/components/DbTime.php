<?php
/**
 * DbTime.php
 *
 * Created by PhpStorm.
 * @date 19.08.18
 * @time 11:52
 */

namespace app\components;

/**
 * Class DbTime
 *
 * Представление времени для БД с микросекундами по-умолчанию
 *
 * @package app\components
 * @since 1.0.0
 */
class DbTime extends \DateTime
{
    /**
     * Преобразование в строку
     * @return string
     */
    public function __toString()
    {
        return $this->format(\DateTime::RFC3339_EXTENDED);
    }
}