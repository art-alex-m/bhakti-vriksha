<?php
/**
 * contactMail.php
 *
 * Письмо обратной связи с сайта
 *
 * Created by PhpStorm.
 * @date 27.08.18
 * @time 10:03
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\User $user Модель пользователя
 * @var string $body Текст обращения
 * @var DateTime $contactDate Дата создания письма
 */
?>
<style>
    dt {
        margin-top: 1em;
        font-weight: bold;
        font-variant: small-caps;
    }

    dt::after {
        content: ":";
    }
</style>
<dl>
    <dt>Пользователь</dt>
    <dd>#<?= $user->id ?> <?= $user->profile->fullName ?></dd>
    <dt>Дата</dt>
    <dd><?= $contactDate->format('d-m-Y H:i:s T') ?></dd>
    <dt>Содержание</dt>
    <dd><?= \yii\helpers\Html::encode($body) ?></dd>
</dl>
