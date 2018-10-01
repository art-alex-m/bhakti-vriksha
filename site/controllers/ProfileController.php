<?php
/**
 * ProfileController.php
 *
 * Created by PhpStorm.
 * @date 24.08.18
 * @time 12:19
 */

namespace app\controllers;

use app\components\GetAuthUserTrait;
use app\rbac\Permissions;
use app\models\Profile;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class ProfileController
 *
 * Контроллер для управления данными в профиле пользователя
 *
 * @package app\controllers
 * @since 1.0.0
 */
class ProfileController extends Controller
{
    use GetAuthUserTrait;

    public $defaultAction = 'update';

    /**
     * Обновляет профиль пользователя. В случае отсутствия профиля, создает новый
     *
     * @return string|\yii\web\Response
     * @throws \Throwable
     */
    public function actionUpdate()
    {
        $user = $this->getAuthUser();
        $profile = $user->profile;
        if (!$profile instanceof Profile) {
            $profile = new Profile();
        }

        if ($profile->load(Yii::$app->request->post())) {
            $profile->userId = $user->id;
            if ($profile->save()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Profile was updated'));
                return $this->redirect(['/profile/']);
            }
        }

        return $this->render('form', ['model' => $profile]);
    }

    /**
     * Просмотр информации в профиле пользователя
     *
     * @param int $id Идентификатор пользователя системы
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Profile::find()
            ->with('user')
            ->andWhere(['=', 'userId', $id])
            ->one();

        if (!$model instanceof Profile) {
            throw new NotFoundHttpException(Yii::t('app', 'Model not found by id #{id}',
                ['id' => $id]));
        }
        Yii::$app->setTimeZone('Europe/Moscow');
        return $this->render('view', ['model' => $model]);
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
                        'actions' => ['update'],
                        'roles' => [Permissions::PERMISSION_PROFILE_UPDATE],
                        'roleParams' => ['userId' => Yii::$app->user->getId()],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [Permissions::PERMISSION_PROFILE_VIEW],
                        'roleParams' => ['userId' => Yii::$app->request->get('id')],
                    ]
                ]
            ]
        ]);
    }
}