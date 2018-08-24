<?php
/**
 * m180803_081245_bv399_profiles_table.php
 *
 * @date 03.08.2018
 * @time 11:14
 */

use yii\db\Migration;
use app\models\Profile;

/**
 * Class m180803_081245_bv399_profiles_table
 *
 * Добавляет таблицу профиля пользователя
 *
 * @since 1.0.0
 */
class m180803_081245_bv399_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = Profile::tableName();
        $this->createTable($tbName, [
            'userId' => 'integer primary key',
            'lastName' => $this->string(100),
            'firstName' => $this->string(100),
            'parentName' => $this->string(100),
            'phone' => $this->string(30),
            'createdAt' => $this->timestamp(4),
            'updatedAt' => $this->timestamp(4),
        ]);

        $this->createIndex('profile_created_at_index', $tbName, 'createdAt');
        $this->createIndex('profile_updated_at_index', $tbName, 'updatedAt');

        $this->addForeignKey(
            'profile_userid_to_user_id_fk',
            $tbName, 'userId',
            \app\models\User::tableName(), 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tbName = Profile::tableName();
        $this->dropForeignKey('profile_userid_to_user_id_fk', $tbName);
        $this->dropIndex('profile_created_at_index', $tbName);
        $this->dropIndex('profile_updated_at_index', $tbName);
        $this->dropTable($tbName);
    }
}
