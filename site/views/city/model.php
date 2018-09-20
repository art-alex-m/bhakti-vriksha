<?php
/**
 * model.php
 *
 * Форма ввода данных для города
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 20:21
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\City $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новый город';
if (!$model->isNewRecord) {
    $this->title = Yii::t('app', 'Изменить запись "{0}"', $model->title);
}
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['/city/']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2><?= Html::encode($this->title) ?></h2>

<div class="row" style="margin-top: 2em;">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'city']);

        echo $form->field($model, 'title')->textInput(['autofocus' => true]);

        if (!$model->isNewRecord) {
            echo $form->field($model, 'status')->dropDownList(\app\models\City::getStatusList());
        }
        ?>

        <div class="form-group" style="margin-top: 2em;">
            <?= Html::a('Отмена',
                ['/city/'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>