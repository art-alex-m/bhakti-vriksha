<?php
/**
 * Mail.php
 *
 * Created by PhpStorm.
 * @date 17.08.18
 * @time 8:41
 */

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Class Mail
 * Класс для отправки сообщений через электронную почту
 *
 * @package app\models
 * @since 1.0.0
 */
class Mail extends Model
{
    /** @var string Имя отправителя */
    public $sender;
    /** @var string Электронный адрес отправителя */
    public $senderEmail;
    /** @var string Тема письма */
    public $subject;
    /** @var string Сообщение */
    public $body;
    /** @var string Имя получателя */
    public $recipient;
    /** @var string Электронный адрес получателя */
    public $recipientEmail;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['recipient', 'recipientEmail', 'sender', 'senderEmail', 'subject', 'body'],
                'required'
            ],
            [['recipientEmail', 'senderEmail'], 'email'],
        ];
    }

    /**
     * Отправляет письмо по указанным реквизитам
     * @return bool Было ли письмо отправлено успешно
     */
    public function send()
    {
        if ($this->validate()) {
            return Yii::$app->mailer->compose([
                'html' => 'dump',
            ], ['content' => $this->body, 'title' => $this->subject])
                ->setTo([$this->recipientEmail => $this->recipient])
                ->setFrom([$this->senderEmail => $this->sender])
                ->setSubject($this->subject)
                ->send();
        }
        return false;
    }
}