<?php
/**
 * m180805_133354_bv399_user_to_leader_table.php
 *
 * @date 06.08.2018
 * @time 16:34
 */

use yii\db\Migration;
use app\models\UserToLeader;
use app\models\User;

/**
 * Class m180805_133354_bv399_user_to_leader_table
 *
 * Создает отношение пользователей к лидерам групп
 *
 * @since 1.0.0
 */
class m180805_133354_bv399_user_to_leader_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = UserToLeader::tableName();
        $this->createTable($tbName, [
            'userId' => 'integer primary key',
            'leaderId' => $this->integer()->unsigned(),
        ]);

        $this->createIndex('users2leaders_leader_index', $tbName, 'leaderId');
        $this->addForeignKey(
            'user2leaders_userid_to_user_id_fk',
            $tbName, 'userId',
            User::tableName(), 'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'user2leaders_leaderid_to_user_id_fk',
            $tbName, 'leaderId',
            User::tableName(), 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tbName = UserToLeader::tableName();
        $this->dropIndex('users2leaders_leader_index', $tbName);
        $this->dropForeignKey('user2leaders_userid_to_user_id_fk', $tbName);
        $this->dropForeignKey('user2leaders_leaderid_to_user_id_fk', $tbName);
        $this->dropTable($tbName);
    }
}
