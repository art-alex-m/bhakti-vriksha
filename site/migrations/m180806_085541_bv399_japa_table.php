<?php
/**
 * m180806_085541_bv399_japa_table.php
 * @date 06.08.2018
 * @time 11:56
 */

use yii\db\Migration;
use app\models\Japa;
use app\models\User;

/**
 * Class m180806_085541_bv399_japa_table
 * Создает отношение статистики по чтению кругов Кришна Махамантры
 *
 * ```sql
 * -- Следует выполнить под учетной записью с правами администратора
 * CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
 * ```
 *
 * su -c 'psql -c "create extension if not exists \"uuid-ossp\"" -d bhakti_vriksha' postgres
 *
 * @since 1.0.0
 */
class m180806_085541_bv399_japa_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = Japa::tableName();
        $this->createTable($tbName, [
            'id' => 'uuid primary key default uuid_generate_v4()',
            'userId' => $this->integer()->unsigned()->notNull(),
            'number' => $this->integer()->unsigned()->notNull(),
            'createdAt' => $this->timestamp(4),
            'updatedAt' => $this->timestamp(4),
        ]);

        $this->createIndex('japa_created_at_index', $tbName, 'createdAt');
        $this->createIndex('japa_userid_index', $tbName, 'userId');

        $this->addForeignKey(
            'japa_userid_user_id_fk',
            $tbName, 'userId',
            User::tableName(), 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tbName = Japa::tableName();
        $this->dropForeignKey('japa_userid_user_id_fk', $tbName);
        $this->dropIndex('japa_created_at_index', $tbName);
        $this->dropIndex('japa_userid_index', $tbName);
        $this->dropTable($tbName);
    }
}
