<?php
/**
 * UserController.php
 *
 * Created by PhpStorm.
 * @date 11.09.18
 * @time 10:36
 */

namespace app\controllers;

use app\models\UsersSearch;
use app\rbac\Permissions;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Class UserController
 * Операции с пользователями системы
 *
 * @package app\controllers
 * @since 1.0.0
 */
class UserController extends Controller
{
    /**
     * Отображение списка пользователей системы
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->setTimeZone('Europe/Moscow');

        $model = new UsersSearch();
        $provider = $model->search(Yii::$app->request->get());
        return $this->render('index', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [Permissions::PERMISSION_USERS_LIST],
                    ],
                ]
            ]
        ]);
    }
}