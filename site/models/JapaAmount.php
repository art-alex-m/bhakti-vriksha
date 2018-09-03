<?php
/**
 * JapaAmount.php
 *
 * Created by PhpStorm.
 * @date 05.09.18
 * @time 15:30
 */

namespace app\models;

use app\components\DateTruncExpression;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class JapaAmount
 * Подсчитывает количество кругов джапы в периоде
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $amount Количество в текущем периоде
 * @property int $startAmount Количество на начало периода всей выборки
 * @property int $previousAmount Количество на начало текущего периода
 * @property int $total Количество с нарастающим итогом
 * @property string $period Наименование текущего периода
 */
class JapaAmount extends ActiveRecord
{
    /** @var int Количество на начало периода */
    protected static $startAmount = 0;
    /** @var int Количество с нарастающим итогом */
    protected static $previousAmount = 0;
    /** @var bool|int Текущее количество всех кругов, для данной модели */
    protected $totalJapa = false;

    /**
     * Возвращает количество с нарастающим итогом. При вычислении в потоке
     * @return int
     */
    public function getTotal()
    {
        if (false === $this->totalJapa) {
            $this->totalJapa = $this->amount + $this->previousAmount;
            self::$previousAmount += $this->amount;
        }
        return $this->totalJapa;
    }

    /**
     * Геттер для [[JapaAmount::$startAmount]]
     * @return int
     */
    public function getStartAmount()
    {
        return self::$startAmount;
    }

    /**
     * Геттер для [[JapaAmount::$previousAmount]]
     * @return int
     */
    public function getPreviousAmount()
    {
        return self::$previousAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $attrs = parent::fields();
        $attrs['previousTotal'] = function () {
            return $this->total - $this->amount;
        };
        $attrs[] = 'total';

        return $attrs;
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'period',
            'amount',
        ];
    }

    /**
     * Устанавливает количество на начало периода
     * @param JapaAmount|null $model
     */
    public static function setStartAmount(JapaAmount $model = null)
    {
        if ($model instanceof JapaAmount) {
            self::$startAmount = $model->amount;
            self::$previousAmount = $model->amount;
        } else {
            self::$startAmount = 0;
            self::$previousAmount = 0;
        }
    }


    /**
     * {@inheritdoc}
     */
    public static function find($period = DateTruncExpression::PERIOD_DAY)
    {
        $query = parent::find();
        $query
            ->alias('ja')
            ->select([
                'amount' => new Expression('SUM(ja.number)'),
                'period' => new DateTruncExpression($period, 'ja."createdAt"')
            ])
            ->groupBy('period');

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['period'];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Japa::tableName();
    }
}