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
use app\models\Profile;
use yii\web\Controller;
use Yii;

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
}