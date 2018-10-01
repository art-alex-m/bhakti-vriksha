<?php
/**
 * form.php
 *
 * Форма обратной связи
 *
 * Created by PhpStorm.
 * @date 24.08.18
 * @time 15:02
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\ContactForm $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2><?= Html::encode($this->title) ?></h2>
<h5>Сообщите нам, если у вас возникли вопросы или пожелания по работе сайта!</h5>
<div class="row">
    <div class="col-lg-5">

        <?php
        $form = ActiveForm::begin(['id' => 'contact']);

        echo $form
            ->field($model, 'text')
            ->textarea(['maxlength' => 3000, 'rows' => 10])
            ->label('');

        echo $form->errorSummary($model);
        ?>

        <div class="form-group">
            <?= Html::a('Отмена',
                ['/contact/'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<div class="row" style="margin-top: 1em;">
    <div class="col-lg-5">
        <h4>Наши контакты:</h4>
        <p>Руководитель проекта: Виктор Рубан</p>
        <p>Адрес эл. почты: <a href="mailto:Виктор Рубан<365d@bk.ru>">365d&commat;bk.ru</a></p>
        <p>Моб. телефон: <a href="tel:+79528752487">+7(952) 875-24-87</a> звонить можно с 10 до 20
            по МСК</p>
    </div>
</div>
