<?php
/**
 * status.php
 *
 * Форма изменения статуса пользователя
 *
 * Created by PhpStorm.
 * @date 13.09.18
 * @time 9:59
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\StatusChangeForm $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = Yii::t('app', 'Изменить статус пользователя #{0}', $model->id);
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

?>
<div class="row">
    <div class="col-lg-3">

        <?php
        $form = ActiveForm::begin(['id' => 'status-change']);

        $list = User::getStatusList();
        $diff = array_diff_key($list, $model->availableStatus);
        $options = array_map(function () {
            return ['disabled' => true];
        }, $diff);

        echo $form
            ->field($model, 'status')
            ->dropDownList($list, ['options' => $options])
            ->label('Статус');
        ?>

        <div class="form-group">
            <?= Html::a('Отмена',
                ['/user/'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']) ?>
            <?= Html::submitButton('Сохранить', [
                'class' => ['btn', 'btn-primary'],
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>