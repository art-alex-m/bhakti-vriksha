<?php
/**
 * m180807_074814_bv399_token_table.php
 *
 * @date 07.08.2018
 * @time 10:48
 */

use yii\db\Migration;
use app\models\Token;
use app\models\User;

/**
 * Class m180807_074814_bv399_token_table
 *
 * Создает отношение для хранения информации о токенах
 *
 * @since 1.0.0
 */
class m180807_074814_bv399_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = Token::tableName();
        $this->createTable($tbName, [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->unsigned(),
            'type' => $this->smallInteger()->notNull(),
            'expiredAt' => $this->timestamp(4)->notNull(),
            'hash' => $this->text()->notNull(),
        ]);

        $this->createIndex('token_hash_index', $tbName, 'hash');
        $this->createIndex('token_userid_index', $tbName, 'userId');

        $this->addForeignKey(
            'token_userid_user_id_fk',
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
        $tbName = Token::tableName();
        $this->dropForeignKey('token_userid_user_id_fk', $tbName);
        $this->dropIndex('token_hash_index', $tbName);
        $this->dropIndex('token_userid_index', $tbName);
        $this->dropTable($tbName);
    }
}
