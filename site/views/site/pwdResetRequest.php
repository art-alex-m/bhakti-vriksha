<?php
/**
 * pwdResetRequest.php
 *
 * Страница для восстановления пароля
 *
 * Created by PhpStorm.
 * @date 21.08.18
 * @time 13:44
 *
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model app\models\LoginForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Password reset');
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'reset-form',
            ]);

            echo $form
                ->field($model, 'email')
                ->textInput(['autofocus' => true])
                ->label('Логин (email)');
            ?>

            <div class="form-group">

                <?php echo Html::submitButton('Далее',
                    ['class' => 'btn btn-primary', 'name' => 'pwd-reset-button']) ?>

            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
