<?php
/**
 * pwdResetForm.php
 *
 * Форма сброса пароля
 *
 * Created by PhpStorm.
 * @date 21.08.18
 * @time 15:51
 *
 * @var yii\web\View $this
 * @var yii\bootstrap\ActiveForm $form
 * @var app\models\PwdResetForm $model
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Измение пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'reset-form',
            ]);

            echo $form->field($model, 'password')->passwordInput(['autofocus' => true]);
            echo $form->field($model, 'confirmPassword')->passwordInput();
            ?>

            <div class="form-group">

                <?php echo Html::submitButton('Сохранить',
                    ['class' => 'btn btn-primary', 'name' => 'pwd-reset-button']) ?>

            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
