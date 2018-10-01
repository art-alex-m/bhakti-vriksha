<?php
/**
 * SiteController.php
 *
 * @date 14.08.2018
 * @time 13:15
 */

namespace app\controllers;

use app\components\GetReturnUriHelper;
use app\models\PwdResetForm;
use app\models\PwdResetRequestForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

/**
 * Class SiteController
 * Основной контроллер сайта
 *
 * @package app\controllers
 * @since 1.0.0
 */
class SiteController extends Controller
{
    /** @var string */
    public $defaultAction = 'login';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            return $this->redirect(GetReturnUriHelper::getUri($user));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(GetReturnUriHelper::getUri(Yii::$app->user));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Отправляет письмо с ссылкой на восстановление пароля
     *
     * @return string|Response
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionPwdResetRequest()
    {
        $model = new PwdResetRequestForm([
            'bodyTpl' => '/site/pwdResetMail',
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->reset()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Please check your email'));
            return $this->goHome();
        }
        return $this->render('pwdResetRequest', ['model' => $model]);
    }

    /**
     * Осуществляет смену пароля пользователя
     *
     * @param string $tkn
     * @return string
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionPwdResetConfirm($tkn)
    {
        try {
            $model = new PwdResetForm($tkn);
            if ($model->load(Yii::$app->request->post()) && $model->reset()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Your password was changed'));
                return $this->redirect(['/site/login']);
            }
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), 0, $e);
        }

        return $this->render('pwdResetForm', ['model' => $model]);
    }
}
