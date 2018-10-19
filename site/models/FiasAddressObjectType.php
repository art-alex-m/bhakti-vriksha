<?php
/**
 * FiasAddressObjectType.php
 *
 * Created by PhpStorm.
 * @date 19.10.18
 * @time 16:28
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class FiasAddressObjectType
 *
 * Тип адресного объекта реестра ФИАС ГАР
 *
 * @package app\models
 * @since 1.1.0
 *
 * @property string $id Идентификатор записи
 * @property int $level Уровень адресного объекта
 * @property string $socrname Полное наименование типа объекта
 * @property string $scname Краткое наименование типа объекта
 * @property int $kod_t_st Ключевое поле, код типа объекта
 */
class FiasAddressObjectType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fias_address_object_type}}';
    }
}