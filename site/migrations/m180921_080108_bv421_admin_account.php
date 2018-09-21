<?php
/**
 * m180921_080108_bv421_admin_account
 *
 * @date 21.09.2018
 * @time 11:16
 */

use yii\db\Migration;
use app\models\User;

/**
 * Class m180921_080108_bv421_admin_account
 * Создает стартовую запись администратора
 * @since 1.0.0
 */
class m180921_080108_bv421_admin_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $form = new \app\models\SignupForm([
            'username' => 'admin@example.com',
            'password' => 'super6',
            'confirmPassword' => 'super6',
        ]);
        $admin = $form->signup();
        if ($admin instanceof User) {

            $admin->status = User::STATUS_ACTIVE;
            $admin->save();

            $auth = Yii::$app->authManager;
            $auth->revokeAll($admin->id);
            $role = $auth->getRole(\app\rbac\Roles::ROLE_SUPERVISOR);
            $auth->assign($role, $admin->id);

            echo PHP_EOL;
            echo 'Admin account was successfully created' . PHP_EOL;
            echo 'Login: admin@example.com' . PHP_EOL;
            echo 'Password: super6' . PHP_EOL;
            echo 'WARNING! After registering a real user, block this account' . PHP_EOL;
            echo PHP_EOL;
            return true;
        }

        print_r($form->getErrors());

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $admin = User::findOne(['username' => 'admin@example.com']);
        if ($admin instanceof User) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($admin->id);

            $admin->delete();

            echo PHP_EOL;
            echo 'Admin account was deleted' . PHP_EOL;
        }
    }
}
