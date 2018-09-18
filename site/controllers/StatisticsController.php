<?php
/**
 * StatisticsController.php
 *
 * Created by PhpStorm.
 * @date 18.09.18
 * @time 13:42
 */

namespace app\controllers;

use app\components\DateTruncExpression as DT;
use app\components\DbTime;
use app\models\StatAggregation;
use app\rbac\Permissions;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Class StatisticsController
 *
 * Реализует сценарии внутренней аналитики проекта по результатам сохраненной статистики
 *
 * @package app\controllers
 * @since 1.0.0
 */
class StatisticsController extends Controller
{
    const DEFAULT_DATE = 'now';

    /**
     * Отображение агрегированной статистики по периодам
     *
     * @param string $d Время среза статистики
     * @param string $p Период агрегации статистики
     * @return string
     */
    public function actionIndex($d = self::DEFAULT_DATE, $p = DT::PERIOD_DAY)
    {
        Yii::$app->setTimeZone('Europe/Moscow');

        $date = $this->getDate($d, $p);

        $query = StatAggregation::find()
            ->andWhere([
                '=',
                new DT($p, 'st."createdAt"'),
                new DT($p, "cast('$date' as date)"),
            ]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['label' => SORT_ASC],
                'attributes' => [
                    'total',
                    'label' => [
                        'asc' => ['type' => SORT_ASC],
                        'desc' => ['type' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'current' => $date,
            'period' => $p,
        ]);
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
                        'actions' => ['index'],
                        'roles' => [Permissions::PERMISSION_STATISTICS_AGG],
                    ]
                ]
            ]
        ]);
    }

    /**
     * Возвращает валидую метку времени для создания среза статистики
     *
     * @param int $d Время среза статистики
     * @param string $p Период агрегации статистики
     * @return DbTime
     */
    protected function getDate($d, &$p)
    {
        if ($d == self::DEFAULT_DATE || !is_numeric($d)) {
            $date = new DbTime();
            switch ($p) {
                case DT::PERIOD_WEEK:
                    $date = $date->modify('monday this week');
                    break;
                case DT::PERIOD_MONTH:
                    $date = $date->modify('first day of this month');
                    break;
                default:
                    $p = DT::PERIOD_DAY;
            }
        } else {
            $date = (new DbTime())->setTimestamp($d);
        }

        $date->setTime(0, 0, 0, 0);

        return $date;
    }
}