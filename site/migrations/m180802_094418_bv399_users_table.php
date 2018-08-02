<?php
/**
 * m180802_094418_bv399_users_table
 * @date 02.08.2018
 * @time 12:46
 */

use yii\db\Migration;
use app\models\User;

/**
 * Class m180802_094418_bv399_users_table
 * Создает таблицу пользователей
 * @since 1.0.0
 */
class m180802_094418_bv399_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = User::tableName();
        $this->createTable($tbName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'authKey' => $this->string(32)->notNull(),
            'passwordHash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_NEW),
            'createdAt' => $this->timestamp(4),
            'updatedAt' => $this->timestamp(4),
        ]);

        $this->createIndex('user_status_index', $tbName, 'status');
        $this->createIndex('user_created_at_index', $tbName, 'createdAt');
        $this->createIndex('user_updated_at_index', $tbName, 'updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tbName = User::tableName();
        $this->dropIndex('user_status_index', $tbName);
        $this->dropIndex('user_created_at_index', $tbName);
        $this->dropIndex('user_updated_at_index', $tbName);
        $this->dropTable($tbName);
    }
}
