<?php
/**
 * SearchTrait
 *
 * Created by PhpStorm.
 * @date 27.01.16
 * @time 11:38
 */

namespace app\components;

/**
 * Class SearchTrait
 * Реализует дополнительные общие задачи настройки родительской модели, предназначенной для
 * поисковых запросов
 *
 * @package app\components
 * @since 1.0.0
 */
trait SearchTrait
{
    /** @var array Атрибут для хранения значений связанных моделей, полученных из гридов */
    protected $explicit = [];

    /**
     * Магический метод для получения значений
     *
     * @param string $name
     * @return null|mixed
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\Exception $e) {
            if (!isset($this->explicit[$name])) {
                return null;
            }
            return $this->explicit[$name];
        }
    }

    /**
     * Магический метод для установки значений
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (\Exception $e) {
            $this->explicit[$name] = $value;
        }
    }

    /**
     * Возвращение значение по имени из [[explicit]]
     *
     * @param string $name
     * @param null|mixed $default
     * @return null|mixed
     */
    public function getExplicit($name, $default = null)
    {
        if (isset($this->explicit[$name])) {
            return $this->explicit[$name];
        }
        return $default;
    }
}
