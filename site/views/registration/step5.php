<?php
/**
 * step5.php
 *
 * Шаг 5. Ввод количества кругов джапы
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 14:34
 *
 * @var \yii\web\View $this
 * @var \app\models\Japa $model
 */

use \yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация. Шаг 5 из 6';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-7">
        <h3>Напишите, пожалуйста, сколько кругов Харе Кришна маха-мантры
            Вы повторяете каждый день</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <?php
        $form = ActiveForm::begin(['id' => 'step5']);

        echo $form
            ->field($model, 'number')
            ->textInput(['autofocus' => true])
            ->label('');
        ?>


        <div class="form-group">
            <?= Html::a('Назад',
                ['step4'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>

            <?= Html::submitButton('Далее',
                ['class' => 'btn btn-success', 'name' => 'registration-step5', 'value' => 5]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

