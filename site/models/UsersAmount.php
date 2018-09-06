<?php
/**
 * UsersAmount.php
 *
 * Created by PhpStorm.
 * @date 04.09.18
 * @time 10:09
 */

namespace app\models;

use app\components\DateTruncExpression;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class UsersAmount
 * Подсчитывает количество пользователей в периоде
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
class UsersAmount extends ActiveRecord
{
    /** @var int Количество на начало периода */
    protected static $startAmount = 0;
    /** @var int Количество с нарастающим итогом */
    protected static $previousAmount = 0;
    /** @var bool|int Текущее количество всех пользователей, для данной модели */
    protected $totalUsers = false;

    /**
     * Возвращает количество с нарастающим итогом. При вычислении в потоке
     * @return int
     */
    public function getTotal()
    {
        if (false === $this->totalUsers) {
            $this->totalUsers = $this->amount + $this->previousAmount;
            self::$previousAmount += $this->amount;
        }
        return $this->totalUsers;
    }

    /**
     * Геттер для [[UsersAmount::$startAmount]]
     * @return int
     */
    public function getStartAmount()
    {
        return self::$startAmount;
    }

    /**
     * Геттер для [[UsersAmount::$previousAmount]]
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
     * @param UsersAmount|null $model
     */
    public static function setStartAmount(UsersAmount $model = null)
    {
        if ($model instanceof UsersAmount) {
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
            ->alias('ua')
            ->select([
                'amount' => new Expression('COUNT(ua.id)'),
                'period' => new DateTruncExpression($period, 'ua."createdAt"')
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
        return User::tableName();
    }
}