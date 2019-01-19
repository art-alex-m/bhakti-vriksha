<?php
/**
 * regActivationMail.php
 *
 * Шаблон письма для отправки токена активации регистрации
 *
 * Created by PhpStorm.
 * @date 17.08.18
 * @time 9:17
 *
 * @var \yii\web\View $this
 * @var \app\models\Token $token
 * @var string $userName
 */

use \yii\helpers\Url;

$url = Url::to(['/registration/activate', 'tkn' => (string)$token], true);
$expired = $token->expiredAsDateTime
    ->setTimezone(new \DateTimeZone('Europe/Moscow'))
    ->format('d-m-Y H:i T');

?>
<h1>Харе Кришна!</h1>
<h2><?= $userName ?>, поздравляем!</h2>
<p>Вы прошли регистрацию на сайте "Центра развития рынка Святого Имени"</p>
<p>Примите наши смиренные поклоны.</p>
<p>Теперь остался последний шаг: активировать свой аккаунт.</p>
<p>Для этого перейдите по ссылке <a href="<?= $url ?>"><?= $url ?></a></p>
<p><strong>Срок действия ссылки до <?= $expired ?></strong></p>

