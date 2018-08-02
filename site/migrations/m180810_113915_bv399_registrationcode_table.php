<?php
/**
 * m180810_113915_bv399_registrationcode_table.php
 *
 * @date 10.08.2018
 * @time 14:40
 */

use yii\db\Migration;
use app\models\RegistrationCode;
use app\models\User;

/**
 * Class m180810_113915_bv399_registrationcode_table
 * Создает отношение для хранения регистрационных кодов пользователей
 * @since 1.0.0
 */
class m180810_113915_bv399_registrationcode_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tbName = RegistrationCode::tableName();
        $this->createTable($tbName, [
            'code' => 'integer primary key',
            'userId' => $this->integer()->unsigned()->notNull(),
            'expiredAt' => $this->timestamp(4)->notNull(),
        ]);

        $this->createIndex('registrationcode_expired_at_index', $tbName, 'expiredAt');
        $this->addForeignKey(
            'registrationcode_userid_user_id_fk',
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
        $tbName = RegistrationCode::tableName();
        $this->dropIndex('registrationcode_expired_at_index', $tbName);
        $this->dropForeignKey('registrationcode_userid_user_id_fk', $tbName);
        $this->dropTable($tbName);
    }
}
