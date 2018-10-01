<?php
/**
 * StatTypesDataProvider.php
 *
 * Created by PhpStorm.
 * @date 01.10.18
 * @time 20:17
 */

namespace app\components;

use app\models\StatAggregation;
use yii\data\ActiveDataProvider;

/**
 * Class StatTypesDataProvider
 *
 * Модель провайдера данных для обработки запросов агрегации статистики
 *
 * @package app\components
 * @since 1.1.0
 */
class StatTypesDataProvider extends ActiveDataProvider
{
    /**
     * {@inheritdoc}
     */
    protected function prepareModels()
    {
        $this->query->indexBy('type');
        $models = [];
        $data = parent::prepareModels();
        $types = StatTypes::getTypesList();

        foreach ($types as $type => $label) {
            if (isset($data[$type])) {
                $models[$type] = $data[$type];
            } else {
                $models[$type] = new StatAggregation([
                    'type' => $type,
                    'total' => 0,
                ]);
            }
        }

        ksort($models);

        return $models;
    }
}