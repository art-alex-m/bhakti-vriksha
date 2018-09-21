<?php
/**
 * Class m180802_130734_bv420_city_dict
 *
 * @date 20.09.2018
 * @time 16:10
 */

use yii\db\Migration;

/**
 * Class m180802_130734_bv420_city_dict
 * Создает отношение для хранения информации о городах
 * @since 1.0.0
 */
class m180802_130734_bv420_city_dict extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tbName = \app\models\City::tableName();
        $this->createTable($tbName, [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger()->notNull(),
            'title' => $this->string(100)->notNull(),
            'createdAt' => $this->timestamp(4),
            'updatedAt' => $this->timestamp(4),
        ]);

        $this->createIndex('city_created_at_index', $tbName, 'createdAt');
        $this->createIndex('city_updated_at_index', $tbName, 'updatedAt');
        $this->createIndex('city_status_index', $tbName, 'status');
        $this->createIndex('city_title_index', $tbName, 'title', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tbName = \app\models\City::tableName();
        $this->dropIndex('city_created_at_index', $tbName);
        $this->dropIndex('city_updated_at_index', $tbName);
        $this->dropIndex('city_status_index', $tbName);
        $this->dropIndex('city_title_index', $tbName);
        $this->dropTable($tbName);
    }
}
