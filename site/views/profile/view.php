<?php
/**
 * view.php
 *
 * Просмотр профиля пользователя
 *
 * Created by PhpStorm.
 * @date 28.08.18
 * @time 15:26
 * @since 1.0.0
 *
 * @var \yii\web\View $this
 * @var \app\models\Profile $model
 */

use \yii\bootstrap\Html;
use \app\rbac\Permissions;

$this->title = Yii::t('app', 'User #{0} profile', $model->userId);
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div', ['class' => 'dl']);

$datesAttr = ['createdAt', 'updatedAt'];
$formatter = Yii::$app->formatter;

echo Html::beginTag('div', ['class' => 'row']);
echo Html::tag('div', 'Email', ['class' => 'dt cell']);
echo Html::tag('div', Html::a($model->user->username,
    Yii::t('app', 'mailto:{0}<{1}>', [$model->fullName, $model->user->username])),
    ['class' => 'dd cell']);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
echo Html::tag('div', 'Город', ['class' => 'dt cell']);
echo Html::tag('div', $model->user->residenceName, ['class' => 'dd cell']);
echo Html::endTag('div');

foreach ($model->attributes as $name => $value) {
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::tag('div', $model->getAttributeLabel($name), ['class' => 'dt cell']);
    if (in_array($name, $datesAttr)) {
        $value = $formatter->asDate($value, 'dd.MM.Y, HH:mm:ss xxx');
    }
    if ($name == 'phone') {
        $value = Html::a($value, Yii::t('app', 'tel:+{0}', $value));
    }
    echo Html::tag('div', $value, ['class' => 'dd cell']);
    echo Html::endTag('div');
}
echo Html::endTag('div');

if (Yii::$app->user->can(Permissions::PERMISSION_PROFILE_UPDATE, ['userId' => $model->userId])) {
    echo Html::tag('div',
        Html::a('Изменить', ['/profile/update'], ['class' => 'btn btn-default']),
        ['style' => 'margin-top: 20px']
    );
}