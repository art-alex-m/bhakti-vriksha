<?php
/**
 * FiasAddressObject.php
 *
 * Created by PhpStorm.
 * @date 19.10.18
 * @time 16:27
 */

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * Class FiasAddressObject
 *
 * Адресный объект реестра ФИАС ГАР
 *
 * @package app\models
 * @since 1.1.0
 *
 * @property string $aoguid Глобальный уникальный идентификатор адресного объекта
 * @property int $aolevel Уровень адресного объекта
 * @property string $parentguid Идентификатор родительского объекта
 * @property string $shortname Краткое наименование типа объекта
 * @property string $offname Официальное наименование
 * @property string $regioncode Код региона
 * @property int $status Статус записи в базе данных
 *
 * @property-read FiasAddressObject $district Район населенного пункта
 * @property-read FiasAddressObject $region Регион населенного пункта
 * @property-read FiasAddressObjectType $type Тип населенного пункта
 */
class FiasAddressObject extends ActiveRecord
{
    const STATUS_ACTIVE = 10; /// активная запись
    const STATUS_ARCHIVE = 20; /// запись в архиве, недоступна для выбора

    /**
     * Связь с типом адресного объекта
     * @see FiasAddressObjectType
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(FiasAddressObjectType::class, ['sortname' => 'scname']);
    }

    /**
     * Связь с моделью региона
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(FiasAddressObject::class, ['regioncode' => 'regioncode'])
            ->andWhere(['=', 'aolevel', 1])
            ->andWhere(['<>', 'aoguid', $this->aoguid]);
    }

    /**
     * Связь с моделью района
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(FiasAddressObject::class, ['aoguid' => 'parentguid']);
    }

    /**
     * Возвращает список статусов
     * @return array
     */
    public static function getStatusList()
    {
        static $list;
        if (is_null($list)) {
            $list = [
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_ARCHIVE => Yii::t('app', 'Archive'),
            ];
        }
        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fias_address_object}}';
    }
}