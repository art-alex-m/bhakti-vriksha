<?php
/**
 * step4.php
 *
 * Регистрация пользователя. Шаг 4. Ввод города проживания
 *
 * Created by PhpStorm.
 * @date 15.08.18
 * @time 14:12
 *
 * @var \yii\web\View $this
 * @var \app\models\Residence $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\City;

$this->title = 'Регистрация. Шаг 4 из 6';
$this->params['breadcrumbs'][] = $this->title;

$list = ArrayHelper::map(City::getCitiesList(), 'id', 'title');
?>
<h2>Введите город проживания</h2>
<div class="row">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'step4']);

        echo $form
            ->field($model, 'cityId')
            ->dropDownList($list)
            ->label('');
        ?>


        <div class="form-group">
            <?= Html::a('Назад',
                ['step3'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']
            ); ?>

            <?= Html::submitButton('Далее',
                ['class' => 'btn btn-success', 'name' => 'registration-step4', 'value' => 4]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
