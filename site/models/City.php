<?php
/**
 * City.php
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 15:45
 */

namespace app\models;

use app\components\ActiveRecord;
use app\components\GetStatusNameTrait;
use Yii;
use yii\db\Query;

/**
 * Class City
 *
 * Город
 *
 * @package app\models
 * @since 1.0.0
 *
 * @property int $id Идентификатор города
 * @property string $title Наименование города
 * @property int $status Статус записи
 */
class City extends ActiveRecord
{
    use GetStatusNameTrait;

    const STATUS_ACTIVE = 10; /// активная запись
    const STATUS_ARCHIVE = 20; /// запись в архиве, недоступна для выбора

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['title', 'required'],
            ['title', 'unique'],
            ['title', 'string', 'max' => 100],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(static::getStatusList())],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'Status'),
            'statusName' => Yii::t('app', 'Status'),
        ]);
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
        return '{{%cities}}';
    }

    /**
     * Возвращает список доступных городов в виде пар id => [id, title, status]
     * @param bool $onlyActive Выбирать только записи со статусом "активна"
     * @param bool $refresh
     * @return array
     */
    public static function getCitiesList($onlyActive = true, $refresh = false)
    {
        static $list;
        if (is_null($list) || $refresh) {
            $query = (new Query())
                ->select(['id', 'title', 'status'])
                ->from(static::tableName())
                ->indexBy('id');

            if ($onlyActive) {
                $query->andWhere(['=', 'status', self::STATUS_ACTIVE]);
            }

            $list = $query->all();
        }
        return $list;
    }
}