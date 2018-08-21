<?php
/**
 * step6.php
 *
 * Шаг 6. Ввод логина и пароля
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 14:55
 *
 * @var \yii\web\View $this
 * @var \app\models\SignupForm $model
 */

use \yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация. Шаг 6 из 6';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Введите email и придумайте пароль</h2>

<div class="row">
    <div class="col-lg-3">
        <?php
        $form = ActiveForm::begin(['id' => 'step6']);
        echo $form->field($model, 'username')->textInput(['placeholder' => 'email@example.com']);
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'confirmPassword')->passwordInput();
        ?>


        <div class="form-group">
            <?= Html::a('Назад',
                ['step5'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>

            <?= Html::submitButton('Завершить',
                ['class' => 'btn btn-success', 'name' => 'registration-step6', 'value' => 6]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
