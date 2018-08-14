<?php
/**
 * GetDbTimestampTrait.php
 *
 * Created by PhpStorm.
 * @date 17.08.18
 * @time 9:43
 */

namespace app\components;

/**
 * Class GetDbTimestampTrait
 * Создает метку времени для пердставления в базе данных
 * @package app\components
 * @since 1.0.0
 */
trait GetDbTimestampTrait
{
    /**
     * Возвращает метку времени для корректного представления в базе данных
     *
     * @param float|int $timestamp
     * @return DbTime
     */
    public static function getDbTimestamp($timestamp)
    {
        $time = explode('.', (string)$timestamp);
        if (!isset($time[1])) {
            $time[1] = 0;
        }
        return (new DbTime())
            ->setTimestamp($time[0])
            ->setTime(
                date('H', $time[0]),
                date('i', $time[0]),
                date('s', $time[0]),
                (int)$time[1]
            );
    }
}