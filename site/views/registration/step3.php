<?php
/**
 * step3.php
 *
 * Шаг 3 регистрации: ввод ФИО
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 13:15
 *
 * @var \yii\web\View $this
 * @var \app\models\Profile $model
 */

use yii\bootstrap\ActiveForm;
use \yii\bootstrap\Html;

$this->title = 'Регистрация. Шаг 3 из 6';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Введите ваши контактные данные</h2>
<div class="row">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'step3']);

        echo $form
            ->field($model, 'lastName')
            ->textInput(['autofocus' => true]);
        echo $form
            ->field($model, 'firstName')
            ->textInput();
        echo $form
            ->field($model, 'parentName')
            ->textInput();
        echo $form->field($model, 'phone')
            ->textInput(['placeholder' => '79876543210']);
        ?>


        <div class="form-group">
            <?= Html::a('Назад',
                ['step2'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>
            <?= Html::submitButton('Далее',
                ['class' => 'btn btn-success', 'name' => 'registration-step3', 'value' => 3]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>