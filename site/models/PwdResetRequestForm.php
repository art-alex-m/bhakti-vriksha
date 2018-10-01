<?php
/**
 * Class PwdResetRequestForm
 *
 * @date 21.08.2018
 * @time 20:20
 */

namespace app\models;

use app\components\GetConfigParamTrait;
use yii\base\Model;
use Yii;

/**
 * Class PwdResetRequestForm
 * Форма запроса на восстановление пароля по Email
 * @package app\models
 */
class PwdResetRequestForm extends Model
{
    use GetConfigParamTrait;

    /** @var string Контактный адрес электронной почты */
    public $email;
    /** @var string Алиас для шаблона письма */
    public $bodyTpl;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'bodyTpl'], 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetAttribute' => 'username',
                'targetClass' => '\app\models\User',
                'filter' => ['=', 'status', User::STATUS_ACTIVE],
                'message' => Yii::t('app', 'There is no user with such email'),
            ],
        ];
    }

    /**
     * Отправляет письмо с ссылкой восстановления пароля
     *
     * @return bool Было ли отправлено письмо
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function reset()
    {
        if (!$this->validate()) {
            return false;
        }

        /* @var User $user */
        $user = User::findByUserName($this->email);

        if ($user) {
            $token = $this->createToken($user);

            if (!$token->isNewRecord) {
                $userName = $user->username;
                if ($user->profile) {
                    $userName = $user->profile->fullName;
                }

                $mail = new Mail([
                    'sender' => Yii::t('app', 'Holly name market'),
                    'senderEmail' => static::getConfigParam('noReplyEmail'),
                    'recipient' => $userName,
                    'recipientEmail' => $this->email,
                    'replyToEmail' => static::getConfigParam('adminEmail'),
                    'subject' => Yii::t('app', 'Password reset for {app}',
                        ['app' => Yii::$app->name]),
                    'body' => $this->renderEmailBody($user, $token),
                ]);
                if ($mail->send()) {
                    return true;
                } else {
                    $this->addError('email', Yii::t('app', 'Cannot send email with error: {error}',
                        ['error' => reset($mail->getFirstErrors())]));
                }
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * Возвращает токен сброса пароля
     *
     * @param User $user
     * @return Token
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    protected function createToken($user)
    {
        $token = Token::find()
            ->andWhere(['=', 'type', Token::TYPE_PWD_RESET])
            ->andWhere(['=', 'userId', $user->id])
            ->one();

        if (!($token && $token->isValid)) {
            if ($token instanceof Token) {
                $token->delete();
            }
            $token = Token::createPwdResetToken($user->id);
            if (!$token->save()) {
                $this->addError('email',
                    Yii::t('app', 'Cannot create password reset token with error: {error}', [
                        'error' => reset($token->getFirstErrors())
                    ]));
            }
        }

        return $token;
    }

    /**
     * Генерирует тело письма для сброса пароля
     * @param User $user
     * @param Token $token
     * @return string
     */
    protected function renderEmailBody($user, $token)
    {
        $view = Yii::$app->getView();
        $body = $view->render($this->bodyTpl, ['user' => $user, 'token' => $token]);
        return $body;
    }
}
