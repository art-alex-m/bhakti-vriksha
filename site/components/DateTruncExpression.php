<?php
/**
 * DateTruncExpression.php
 *
 * Created by PhpStorm.
 * @date 04.09.18
 * @time 11:27
 */

namespace app\components;

use yii\db\Expression;

/**
 * Class DateTruncExpression
 * Обощает данные времени по заданному периоду
 *
 * @link https://www.postgresql.org/docs/9.6/static/functions-datetime.html#FUNCTIONS-DATETIME-TRUNC
 * @package app\components
 * @since 1.0.0
 */
class DateTruncExpression extends Expression
{
    const PERIOD_DAY = 'day';
    const PERIOD_MONTH = 'month';
    const PERIOD_YEAR = 'year';
    const PERIOD_HOUR = 'hour';
    const PERIOD_MILLENNIUM = 'millennium';

    /** @var string Наименование поля записи */
    protected $column;
    /** @var string Наименование периода обобщения */
    protected $period;

    /**
     * DateTruncExpression constructor.
     *
     * @param string $period Период обобщения
     * @param string $column Наименование поля обобщения
     * @param array $config
     */
    public function __construct($period, $column, $config = [])
    {
        $this->period = $period;
        $this->column = $column;
        parent::__construct('date_trunc(\'%s\', %s)', [], $config);
    }

    /**
     * Преобразование в строку
     * @return string the DB expression.
     */
    public function __toString()
    {
        return sprintf($this->expression, $this->period, $this->column);
    }
}