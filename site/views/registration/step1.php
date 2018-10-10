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

$this->title = 'Введите код';
$this->params['breadcrumbs'][] = $this->title;

?>

<h2>Центр развития рынка Святого Имени. ИСККОН (Россия)</h2>

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
            <?= Html::a('У меня уже есть аккаунт', ['/site/login'],
                ['style' => ['margin-left' => '5pt']]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>