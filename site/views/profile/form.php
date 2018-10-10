<?php
/**
 * form.php
 *
 * Форма для изменения данных профиля пользователя
 *
 * Created by PhpStorm.
 * @date 24.08.18
 * @time 12:28
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\Profile $model
 */

use yii\bootstrap\ActiveForm;
use \yii\bootstrap\Html;

$this->title = 'Изменить профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

?>
<div class="row">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'profile']);

        echo $form
            ->field($model, 'lastName')
            ->textInput(['autofocus' => true]);
        echo $form->field($model, 'firstName');
        echo $form->field($model, 'parentName');
        echo $form->field($model, 'phone')->textInput(['placeholder' => '79876543210']);
        ?>

        <div class="form-group">
            <?= Html::a('Отмена',
                ['/profile/view', 'id' => $model->userId],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>