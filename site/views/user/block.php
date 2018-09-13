<?php
/**
 * block.php
 *
 * Форма добровольной блокировки учетной записи
 *
 * Created by PhpStorm.
 * @date 13.09.18
 * @time 14:27
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 */

use yii\bootstrap\Html;

$this->title = 'Заблокировать учетную запись';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
jQuery(function($){
    let btn = $('#block-submit-btn');
    let check = $('#do-self-block');
    check.click(function() {
        btn.prop('disabled', !check.prop('checked'));
    });
});
JS;

$this->registerJs($js, \yii\web\View::POS_END);

?>
<h2 style="color:#e60000;">Внимание!</h2>
<h4>Вы хотите произвести блокировку своей учетной записи?</h4>
<p>В этом случае Ваши персональные данные, такие как: фамилия, имя, отчество, -
    будут безвозвратно удалены, а вход на сайт будет заблокирован. В дальнейшем никто не сможет
    использовать Ваш логин для повторной регистрации в системе.</p>
<p>Если Ваша роль слуга-лидер или выше, то, пожалуйста, убедитесь, что зависящие от Вас участники
    групп бхакти-врикш были успешно переданы другому лидеру.</p>

<div class="row">
    <div class="col-lg-10">
        <?php
        echo Html::beginForm(['/user/block'], 'post', ['id' => 'user-block']);
        echo Html::tag('br');
        echo Html::checkbox('do-self-block', false, [
            'label' => 'Я понимаю и принимаю все последствия своего решения',
            'id' => 'do-self-block',
        ]);
        ?>

        <div class="form-group" style="margin-top: 15px;">
            <?= Html::a('Отмена',
                ['/'],
                ['class' => 'btn btn-default', 'style' => 'margin-right:5px;']) ?>
            <?= Html::submitButton('Заблокировать', [
                'class' => ['btn', 'btn-danger'],
                'disabled' => true,
                'id' => 'block-submit-btn',
            ]) ?>
        </div>

        <?php echo Html::endForm() ?>
    </div>
</div>


