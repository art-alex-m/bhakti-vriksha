<?php
/**
 * m180803_092053_bv399_residence_table.php
 *
 * @date 03.08.2018
 * @time 12:21
 */

use yii\db\Migration;
use app\models\Residence;

/**
 * Class m180803_092053_bv399_residence_table
 *
 * Создает отношение пользователей с городами проживания
 *
 * @since 1.0.0
 */
class m180803_092053_bv399_residence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tbName = Residence::tableName();
        $this->createTable($tbName, [
            'userId' => 'integer primary key',
            'title' => $this->string(100)->notNull(),
            'createdAt' => $this->timestamp(4),
            'updatedAt' => $this->timestamp(4),
        ]);

        $this->createIndex('residence_created_at_index', $tbName, 'createdAt');
        $this->createIndex('residence_updated_at_index', $tbName, 'updatedAt');

        $this->addForeignKey(
            'residence_userid_to_user_id_fk',
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
        $tbName = Residence::tableName();
        $this->dropForeignKey('residence_userid_to_user_id_fk', $tbName);
        $this->dropIndex('residence_created_at_index', $tbName);
        $this->dropIndex('residence_updated_at_index', $tbName);
        $this->dropTable($tbName);
    }
}
