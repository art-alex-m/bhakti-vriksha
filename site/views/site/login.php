<?php
/**
 * login.php
 *
 * Created by PhpStorm.
 * @date 14.08.18
 * @time 13:49
 *
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model app\models\LoginForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'System login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, для входа в систему заполните следующие поля:</p>
    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]);

            echo $form->field($model, 'username')->textInput(['autofocus' => true]);

            echo $form->field($model, 'password')->passwordInput();

            echo $form->field($model, 'rememberMe')->checkbox();

            ?>

            <div class="form-group">

                <?php echo Html::submitButton(Yii::t('app', 'Login'),
                    ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                <?php echo Html::a(Yii::t('app', 'Sign up'), ['/registration'],
                    ['class' => 'btn btn-default']) ?>

                <?php echo Html::a('Забыли пароль?', ['/site/pwd-reset-request'],
                    ['class' => 'btn']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
