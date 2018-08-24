<?php
/**
 * form.php
 *
 * Форма по вводу данных джапы
 *
 * Created by PhpStorm.
 * @date 23.08.18
 * @time 16:19
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\Japa $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ежедневное количество кругов джапы за предыдущий месяц';
$this->params['breadcrumbs'][] = ['label' => 'Круги', 'url' => ['/japa/']];
$this->params['breadcrumbs'][] = $this->title;

$newDate = (new DateTime($model->createdAt))->setTimezone(new DateTimeZone('Europe/Moscow'));
$period = Yii::$app->formatter->asDate($newDate, 'd MMMM Y');

?>
<div class="row">
    <div class="col-lg-7">
        <h2><?= Html::encode($this->title) ?></h2>
        <h3>На <?= $period ?></h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-3">
        <?php
        $form = ActiveForm::begin(['id' => 'new-japa-form']);

        echo $form
            ->field($model, 'number')
            ->textInput(['autofocus' => true]);
        ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
