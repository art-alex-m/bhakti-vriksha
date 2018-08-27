<?php
/**
 * RegcodeController.php
 *
 * Created by PhpStorm.
 * @date 27.08.18
 * @time 12:40
 */

namespace app\controllers;

use app\components\GetAuthUserTrait;
use app\models\RegistrationCode;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

/**
 * Class RegcodeController
 *
 * Контроллер для управления кодом регистрации
 *
 * @package app\controllers
 * @since 1.0.0
 */
class RegcodeController extends Controller
{
    use GetAuthUserTrait;

    /**
     * Отображает действующие коды регистрации
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->setTimeZone('Europe/Moscow');

        $user = $this->getAuthUser();
        $codes = new ActiveDataProvider([
            'query' => RegistrationCode::find()->andWhere(['=', 'userId', $user->id]),
            'sort' => ['defaultOrder' => ['expiredAt' => SORT_ASC]],
        ]);

        return $this->render('index', ['model' => $codes]);
    }

    /**
     * Создает новый код регистрации
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $submit = Yii::$app->request->post('reg-code-create');

        if ($submit) {
            $user = $this->getAuthUser();
            RegistrationCode::clearExpired();
            $code = RegistrationCode::create($user->id);
            if ($code->save()) {
                Yii::$app->session->addFlash('success',
                    Yii::t('app', 'Registration code #{0} was created', $code->code));
            }
        }

        return $this->redirect('index');
    }
}