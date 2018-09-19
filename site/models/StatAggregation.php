<?php
/**
 * StatAggregation.php
 *
 * Created by PhpStorm.
 * @date 18.09.18
 * @time 15:11
 */

namespace app\models;

use app\components\OnlySearchTrait;
use app\components\StatTypes;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

/**
 * Class StatAggregation
 *
 * Класс для агрегации статистики действий пользователей по типам
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $type Тип действия пользователя в системе
 * @property int $total Количество зарегистрированных действий за период
 * @property-read string $label Наименование типа действия
 */
class StatAggregation extends ActiveRecord
{
    use OnlySearchTrait;

    /**
     * Возвращает наименование типа действия пользователя
     * @return int|string
     */
    public function getLabel()
    {
        $types = StatTypes::getTypesList();
        if (isset($types[$this->type])) {
            return $types[$this->type];
        }
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'type',
            'total',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['type'];
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        /** @var ActiveQuery $query */
        $query = Yii::createObject(ActiveQuery::class, [static::class]);
        $query
            ->alias('st')
            ->select([
                'type',
                'total' => new Expression('COUNT(st.id)'),
            ])
            ->groupBy('st.type');

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Statistics::tableName();
    }
}