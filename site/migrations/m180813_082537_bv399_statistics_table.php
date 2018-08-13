<?php
/**
 * m180813_082537_bv399_statistics_table.php
 *
 * @date 13.08.2018
 * @time 11:26
 */

use yii\db\Migration;
use app\models\Statistics;
use app\models\User;

/**
 * Class m180813_082537_bv399_statistics_table
 *
 * Создает отношение для хранения информации о действиях пользователей в системе
 *
 * @since 1.0.0
 */
class m180813_082537_bv399_statistics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tbName = Statistics::tableName();
        $this->createTable($tbName, [
            'id' => 'uuid primary key default uuid_generate_v4()',
            'userId' => $this->integer()->unsigned()->notNull(),
            'type' => $this->smallInteger()->unsigned()->notNull(),
            'createdAt' => $this->timestamp(4),
        ]);

        $this->createIndex('statistics_userid_index', $tbName, 'userId');
        $this->createIndex('statistics_type_index', $tbName, 'type');
        $this->createIndex('statistics_created_at_index', $tbName, 'createdAt');

        $this->addForeignKey(
            'statistics_userid_user_id_fk',
            $tbName, 'userId',
            User::tableName(), 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tbName = Statistics::tableName();
        $this->dropForeignKey('statistics_userid_user_id_fk', $tbName);
        $this->dropIndex('statistics_userid_index', $tbName);
        $this->dropIndex('statistics_type_index', $tbName);
        $this->dropIndex('statistics_created_at_index', $tbName);
        $this->dropTable($tbName);
    }
}
