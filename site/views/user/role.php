<?php
/**
 * role.php
 *
 * Форма смены роли пользователя
 *
 * Created by PhpStorm.
 * @date 12.09.18
 * @time 9:23
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\RoleChangeForm $model
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Изменить роль пользователя #{0}', $model->id);

$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

?>
<div class="row">
    <div class="col-lg-4">

        <?php
        $form = ActiveForm::begin(['id' => 'role-change']);
        $available = $model->getAvailableRoles();
        if ($model->user) {
            $model->roles = array_keys($model->user->roles);
        }
        echo $form->field($model, 'roles')->checkboxList($available)
            ->label('Доступные роли пользователя');
        ?>

        <div class="form-group">
            <?= Html::a('Отмена',
                ['/user/'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']) ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>