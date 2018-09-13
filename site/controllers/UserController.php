<?php
/**
 * UserController.php
 *
 * Created by PhpStorm.
 * @date 11.09.18
 * @time 10:36
 */

namespace app\controllers;

use app\models\RoleChangeForm;
use app\models\StatusChangeForm;
use app\models\UsersSearch;
use app\rbac\Permissions;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

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
     * Изменяет роль пользователя
     *
     * @param int $id Идентификатор пользователя
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionRole($id)
    {
        $model = new RoleChangeForm(['id' => $id]);
        if (!$model->validate('id')) {
            throw new NotFoundHttpException(Yii::t('app', 'Model not found by id #{id}',
                ['id' => $id]));
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->assign()) {
                Yii::$app->session->addFlash('success',
                    Yii::t('app', 'User #{0} roles were updated', $id));
                return $this->refresh();
            }
        }
        return $this->render('role', ['model' => $model]);
    }

    /**
     * @param int $id Идентификатор пользователя
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        $model = new StatusChangeForm(['id' => $id]);

        if (!$model->validate('id')) {
            throw new NotFoundHttpException(Yii::t('app', 'Model not found by id #{id}',
                ['id' => $id]));
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->change()) {
                Yii::$app->session->addFlash('success',
                    Yii::t('app', 'User #{0} status was updated', $id));
                return $this->refresh();
            }
        }

        $model->setDefaultStatus();

        return $this->render('status', ['model' => $model]);
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
                    [
                        'allow' => true,
                        'actions' => ['role'],
                        'roles' => [Permissions::PERMISSION_USER_ROLE_UPDATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['status'],
                        'roles' => [Permissions::PERMISSION_USER_STATUS_UPDATE],
                    ],
                ]
            ]
        ]);
    }
}