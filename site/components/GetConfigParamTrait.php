<?php
/**
 * GetConfigParamTrait.php
 *
 * Created by PhpStorm.
 * @date 06.08.18
 * @time 19:51
 */

namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Trait GetConfigParamTrait
 *
 * Возвращает значение параметра конфигурации
 *
 * @package app\components
 * @since 1.0.0
 */
trait GetConfigParamTrait
{
    /**
     * Возвращает значение параметра конфигурации
     *
     * @param array|string|\Closure $key Идентификатор в параметрах конфигурации
     * @param null|mixed $default Значение по умолчанию, если параметр не задан
     * @return mixed|null
     */
    protected static function getConfigParam($key, $default = null)
    {
        return ArrayHelper::getValue(Yii::$app->params, $key, $default);
    }
}