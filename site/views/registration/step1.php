<?php
/**
 * step1.php
 *
 * Шаг 1 при регистрации пользователя: Ввод кода регистрации
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 11:05
 *
 * @var \yii\web\View $this
 * @var \app\models\RegistrationCode $model
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Регистрация. Шаг 1 из 6';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>Центр развития рынка Святого Имени</h1>

<p>ИСККОН (Россия)</p>

<div class="row">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'step1']);

        echo $form
            ->field($model, 'code')
            ->textInput(['autofocus' => true, 'placeholder' => 'Введите код'])
            ->label('')
            ->hint('Получите код у лидера группы');
        ?>


        <div class="form-group">
            <?= Html::submitButton('Далее',
                ['class' => 'btn btn-success', 'name' => 'registration-step1', 'value' => 1]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>