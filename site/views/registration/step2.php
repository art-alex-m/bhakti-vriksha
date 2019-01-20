<?php
/**
 * step2.php
 *
 * Шаг 2 при регистрации пользователя: чтение информации о проекте
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 12:42
 */

use \yii\bootstrap\Html;

$this->title = 'Приветствие';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Приветствуем Вас!</h2>
<br>
<p>Вы зашли на сайт &laquo;Центр развития Рынка Святого Имени&raquo;.</p>
    <br>
    <p>Спасибо, что согласились принять участие в этом проекте!</p>
    <p>Чтобы начать пользоваться сайтом, Вам необходимо пройти регистрацию, которая
        состоит из 4-х шагов.</p>

<div style="margin-top: 25px;">
<?= Html::a('Отмена',
    ['/'],
    ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
); ?>
<?= Html::a('Далее', ['registration/step3'], ['class' => 'btn btn-success']); ?>
</div>
