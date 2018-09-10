<?php
/**
 * C3ChartController.php
 *
 * Created by PhpStorm.
 * @date 04.09.18
 * @time 10:10
 */

namespace app\controllers;

use app\components\DateTruncExpression;
use app\components\DbTime;
use app\models\C3JsonData;
use app\models\JapaAmount;
use app\models\UsersAmount;
use yii\filters\AccessControl;
use yii\rest\Controller;
use Yii;

/**
 * Class C3ChartController
 * Контроллер для предоставления данных для диаграмм С3
 *
 * @package app\controllers
 * @since 1.0.0
 */
class C3ChartController extends Controller
{
    /**
     * Подсчитывает количество пользователей по периодам
     * @param string $period
     * @return C3JsonData
     */
    public function actionUsersAmount($period = DateTruncExpression::PERIOD_DAY)
    {
        $date = $this->getStartDate($period);

        $startAmount = UsersAmount::find(DateTruncExpression::PERIOD_MILLENNIUM)
            ->andWhere(['<', 'createdAt', $date])->one();

        UsersAmount::setStartAmount($startAmount);

        $query = UsersAmount::find($period)
            ->andWhere(['>=', 'createdAt', $date])
            ->orderBy(['period' => SORT_ASC]);

        $data = new C3JsonData([
            'json' => $query->all(),
            'keys' => [
                'x' => 'period',
                'value' => ['total'],
            ],
            'names' => [
                'total' => Yii::t('app', 'Total participants'),
            ],
        ]);

        return $data;
    }

    /**
     * Подсчитывает количество кругов по периодам
     * @param string $period
     * @return C3JsonData
     */
    public function actionJapaAmount($period = DateTruncExpression::PERIOD_DAY)
    {
        $date = $this->getStartDate($period);

        $startAmount = JapaAmount::find(DateTruncExpression::PERIOD_MILLENNIUM)
            ->andWhere(['<', 'createdAt', $date])->one();

        JapaAmount::setStartAmount($startAmount);

        $query = JapaAmount::find($period)
            ->andWhere(['>=', 'createdAt', $date])
            ->orderBy(['period' => SORT_ASC]);

        $data = new C3JsonData([
            'json' => $query->all(),
            'keys' => [
                'x' => 'period',
                'value' => ['total'],
            ],
            'names' => [
                'total' => Yii::t('app', 'Total circles'),
                'previousTotal' => Yii::t('app', 'In previous period'),
                'amount' => Yii::t('app', 'In current period'),
            ],
        ]);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['users-amount', 'japa-amount'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ]);
    }

    /**
     * Возвращает стартовую дату периода
     * @param int $period
     * @return DbTime
     */
    protected function getStartDate($period)
    {
        $date = new DbTime();
        switch ($period) {
            case DateTruncExpression::PERIOD_MONTH:
                return $date->modify('first day of this month 00:00:00')->modify('-11 month');
            case DateTruncExpression::PERIOD_YEAR:
                return $date->modify('first day of january this year 00:00:00')->modify('-4 years');
            default:
                return $date->modify('-30 days 00:00:00');
        }
    }
}