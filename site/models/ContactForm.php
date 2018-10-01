<?php
/**
 * ContactForm.php
 *
 * Created by PhpStorm.
 * @date 27.08.18
 * @time 9:39
 */

namespace app\models;

use app\components\GetAuthUserTrait;
use app\components\GetConfigParamTrait;
use Yii;

/**
 * Class ContactForm
 *
 * Модель для обработки писем обратной связи
 *
 * @package app\models
 * @since 1.0.0
 */
class ContactForm extends Mail
{
    use GetAuthUserTrait,
        GetConfigParamTrait;

    /** @var string Алиас для шаблона письма */
    public $bodyTpl;
    /** @var string Оригинальный текст письма */
    public $text;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['text', 'trim'],
            [['bodyTpl', 'text'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $user = $this->getAuthUser();
        $userName = $user->username;
        if ($user->profile) {
            $userName = $user->profile->fullName;
        }

        $this->recipient = Yii::t('app', '{0} admin', Yii::$app->name);
        $this->recipientEmail = $this->getConfigParam('adminEmail');
        $this->sender = Yii::t('app', 'Holly name market');
        $this->senderEmail = $this->getConfigParam('noReplyEmail');
        $this->body = $this->renderBody();
        $this->replyToEmail = $user->username;
        $this->replyTo = $userName;
        $this->subject = Yii::t('app', '{app} contact message from {username}', [
            'app' => Yii::$app->name,
            'username' => $userName,
        ]);

        if (!$this->validate('replyToEmail')) {
            $this->replyToEmail = null;
        }

        return parent::send();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'text' => Yii::t('app', 'Message'),
        ]);
    }

    /**
     * Формирует текст письма в виде html
     * @return string
     * @throws \Throwable
     */
    protected function renderBody()
    {
        $user = $this->getAuthUser();
        $view = Yii::$app->getView();
        return $view->render($this->bodyTpl, [
            'user' => $user,
            'body' => $this->text,
            'contactDate' => (new \DateTime())->setTimezone(new \DateTimeZone('Europe/Moscow')),
        ]);
    }
}