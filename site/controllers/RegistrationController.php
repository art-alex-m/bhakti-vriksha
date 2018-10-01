<?php
/**
 * RegistrationController.php
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 10:33
 */

namespace app\controllers;

use app\components\GetConfigParamTrait;
use app\components\GetReturnUriHelper;
use app\components\RegistrationStatBehavior;
use app\models\Japa;
use app\models\Mail;
use app\models\Profile;
use app\models\RegistrationCode;
use app\models\Residence;
use app\models\SignupForm;
use app\models\Token;
use app\models\User;
use app\models\UserToLeader;
use app\components\Event;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;

/**
 * Class RegistrationController
 * Контроллер для регистрации пользователей сервиса
 *
 * @package app\controllers
 * @since 1.0.0
 */
class RegistrationController extends Controller
{
    use GetConfigParamTrait;

    /** @var string Событие после успешной регистрации пользователя */
    const EVENT_AFTER_REGISTRATION = 'afterRegistration';

    /** @var string Действие по умолчанию */
    public $defaultAction = 'step1';

    /**
     * Шаг 1. Ввод кода регистрации
     * @return string
     */
    public function actionStep1()
    {
        $request = Yii::$app->request;
        $model = RegistrationCode::findByCode(
            ArrayHelper::getValue($request->post(), 'RegistrationCode.code', 0));

        if (!$model instanceof RegistrationCode) {
            $model = new RegistrationCode();
        }

        if ($model->isValid) {
            Yii::$app->session->set('RegistrationCode', serialize($model));
            return $this->redirect(['step2']);
        } else {
            Yii::$app->session->remove('RegistrationCode');
        }

        if ($request->post('registration-step1', 0) == 1) {
            $model->addError('code', Yii::t('app', 'Code is invalid'));
        }

        return $this->render('step1', [
            'model' => $model,
        ]);
    }

    /**
     * Шаг 2. Чтение информации о проекте
     * @return string
     */
    public function actionStep2()
    {
        if ($this->validateSessionCode()) {
            return $this->render('step2');
        }
        return $this->redirect(['step1']);
    }

    /**
     * Шаг 3. Ввод контактных данных
     * @return string|\yii\web\Response
     */
    public function actionStep3()
    {
        if (!$this->validateSessionCode()) {
            return $this->redirect(['step1']);
        }

        $request = Yii::$app->request;
        $model = new Profile();

        if ($model->load($request->post()) &&
            $model->validate(['firstName', 'lastName', 'parentName', 'phone'])
        ) {
            $data = serialize($model);
            Yii::$app->session->set('Profile', $data);
            return $this->redirect(['step4']);
        };

        $model = $this->getFromSession('Profile', $model);

        return $this->render('step3', ['model' => $model]);
    }

    /**
     * Шаг 4. Ввод города проживания
     * @return string
     */
    public function actionStep4()
    {
        if (!$this->validateSessionCode()) {
            return $this->redirect(['step1']);
        }

        $request = Yii::$app->request;
        $model = new Residence();

        if ($model->load($request->post()) &&
            $model->validate(['cityId'])
        ) {
            $data = serialize($model);
            Yii::$app->session->set('Residence', $data);
            return $this->redirect(['step5']);
        };

        $model = $this->getFromSession('Residence', $model);

        return $this->render('step4', ['model' => $model]);
    }

    /**
     * Шаг 5. Ввод количества кругов джапы
     * @return string|\yii\web\Response
     */
    public function actionStep5()
    {
        if (!$this->validateSessionCode()) {
            return $this->redirect(['step1']);
        }

        $request = Yii::$app->request;
        $model = new Japa();

        if ($model->load($request->post()) &&
            $model->validate(['number'])
        ) {
            $data = serialize($model);
            Yii::$app->session->set('Japa', $data);
            return $this->redirect(['step6']);
        };

        $model = $this->getFromSession('Japa', $model);

        return $this->render('step5', ['model' => $model]);
    }

    /**
     *  Шаг 6. Ввод логина, пароля, номера телефона
     *
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionStep6()
    {
        if (!$this->validateSessionCode()) {
            return $this->redirect(['step1']);
        }

        $request = Yii::$app->request;
        $model = new SignupForm();

        if ($model->load($request->post()) &&
            $model->validate()
        ) {
            $code = $this->getFromSession('RegistrationCode');
            $code = RegistrationCode::findByCode($code->code);
            if ($code instanceof RegistrationCode && $code->isValid) {
                $tr = Yii::$app->db->beginTransaction();
                $user = $model->signup();
                if ($user instanceof User) {
                    $profile = $this->getFromSession('Profile', new Profile());
                    $japa = $this->getFromSession('Japa', new Japa());
                    $residence = $this->getFromSession('Residence', new Residence());
                    $user2leader = new UserToLeader([
                        'userId' => $user->id,
                        'leaderId' => $code->userId
                    ]);

                    $profile->userId = $user->id;
                    $japa->userId = $user->id;
                    $residence->userId = $user->id;

                    $profile->save();
                    $japa->save();
                    $residence->save();
                    $user2leader->save();

                    $rote = false;
                    if ($profile->hasErrors()) {
                        $rote = ['step3'];
                    } elseif ($residence->hasErrors()) {
                        $rote = ['step4'];
                    } elseif ($japa->hasErrors()) {
                        $rote = ['step5'];
                    }
                    if ($rote) {
                        $tr->rollBack();
                        return $this->redirect($rote);
                    }
                    $code->delete();
                    $this->clearSession();

                    /// Создает и отправляет письмо с токеном активации
                    $token = $this->createRegActivationToken($user);
                    $this->sendRegActivationEmail($user, $token);

                    $tr->commit();
                    $this->trigger(self::EVENT_AFTER_REGISTRATION, new Event([
                        'context' => ['user' => $user],
                    ]));
                    return $this->redirect(['success']);
                }
                $tr->rollBack();
            } else {
                return $this->redirect(['step1']);
            }
        };

        return $this->render('step6', ['model' => $model]);
    }

    /**
     * Завершающая страница успешной регистрации
     * @return string
     */
    public function actionSuccess()
    {
        return $this->render('successAnnotation');
    }

    /**
     * Активирует аккаунт пользователя по ссылке с токеном
     *
     * @param string $tkn
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionActivate($tkn)
    {
        $token = Token::find()
            ->andWhere(['=', 'hash', $tkn])
            ->andWhere(['=', 'type', Token::TYPE_REG_CONFIRM])
            ->andWhere(['>=', 'expiredAt', new Expression('NOW()')])
            ->with('user')
            ->one();

        if ($token instanceof Token) {
            $user = $token->user;
            if ($user->status == User::STATUS_NEW) {
                $user->status = User::STATUS_ACTIVE;
                if ($user->save()) {
                    $token->delete();
                    Yii::$app->session->addFlash('success',
                        Yii::t('app', 'Your account has been successfully activated'));
                    return $this->redirect(['/site/login']);
                }
            }
        }
        throw new BadRequestHttpException(Yii::t('app', 'Wrong activation token'));
    }

    /**
     * Очистка текущей сессии
     * @return \yii\web\Response
     */
    public function actionClearSession()
    {
        $this->clearSession();
        return $this->redirect(['step1']);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            RegistrationStatBehavior::class,
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    $uri = GetReturnUriHelper::getUri();
                    return $this->redirect($uri);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Проверяет код регистрации в сессии
     * @return bool
     */
    protected function validateSessionCode()
    {
        $code = $this->getFromSession('RegistrationCode');
        return ($code instanceof RegistrationCode && $code->isValid);
    }

    /**
     * Возвращает значение, сохраненное в сессии
     * @param string $key
     * @param null|mixed $default
     * @return mixed
     */
    protected function getFromSession($key, $default = null)
    {
        $data = Yii::$app->session->get($key);
        return $data ? unserialize($data) : $default;
    }

    /**
     * Удаляет из сессии все регистрационные данные
     */
    protected function clearSession()
    {
        $keys = ['Profile', 'Residence', 'RegistrationCode', 'Japa'];
        foreach ($keys as $key) {
            Yii::$app->session->remove($key);
        }
    }

    /**
     * Отправляет письмо пользователю с токеном активации регистрации
     *
     * @param User $user
     * @param Token $token
     * @throws \RuntimeException
     */
    protected function sendRegActivationEmail(User $user, Token $token)
    {
        $body = $this->renderAjax('regActivationMail', [
            'token' => $token,
            'userName' => $user->profile->firstName . ' ' . $user->profile->parentName,
        ]);
        $mail = new Mail([
            'body' => $body,
            'recipientEmail' => $user->username,
            'recipient' => $user->profile->fullName,
            'subject' => Yii::t('app', 'Registration activation'),
            'sender' => Yii::t('app', 'Holly name market'),
            'senderEmail' => $this->getConfigParam('noReplyEmail', 'no-reply@example.com'),
            'replyToEmail' => $this->getConfigParam('adminEmail', 'admin@example.com'),
        ]);
        if (!$mail->send()) {
            throw new \RuntimeException(Yii::t('app',
                'Cannot send registration activation email for user #{id}. Please contact with administrator',
                ['id' => $user->id]));
        }
    }

    /**
     * Создает токен активации для пользователя
     *
     * @param User $user
     * @return Token
     * @throws \yii\base\Exception
     */
    protected function createRegActivationToken(User $user)
    {
        $token = Token::createRegConfirmToken($user->id);
        if (!$token->save()) {
            throw new \RuntimeException(Yii::t('app',
                'Cannot create registration activation token for user #{id}',
                ['id' => $user->id]));
        }
        return $token;
    }
}