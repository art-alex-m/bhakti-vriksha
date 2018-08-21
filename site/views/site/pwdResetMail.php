<?php
/**
 * pwdResetMail.php
 *
 * Created by PhpStorm.
 * @date 21.08.18
 * @time 13:15
 * @var yii\web\View $this
 * @var app\models\Token $token
 * @var app\models\User $user
 */

use \yii\helpers\Url;

$userName = $user->profile->fullName;
$url = Url::to(['/site/pwd-reset-confirm', 'tkn' => (string)$token], true);
$expired = $token->expiredAsDateTime
    ->setTimezone(new \DateTimeZone('Europe/Moscow'))
    ->format('d-m-Y H:i T');

?>
<h1>Харе Кришна!</h1>
<h2><?= $userName ?>, доброго времени суток!</h2>
<p>Вы захотели изменить пароль к личному кабинету на сайте
    "Центра развития рынка Святого Имени. ИСККОН (Россия)"</p>
<p>Примите наши смиренные поклоны.</p>
<p>Теперь остался последний шаг: задать новый пароль.</p>
<p>Для этого перейдите по ссылке <a href="<?= $url ?>"><?= $url ?></a></p>
<p><strong>Срок действия ссылки до <?= $expired ?></strong></p>