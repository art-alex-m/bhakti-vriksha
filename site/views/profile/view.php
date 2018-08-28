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

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['/group/list']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

echo Html::beginTag('dl');

$datesAttr = ['createdAt', 'updatedAt'];
$formatter = Yii::$app->formatter;

echo Html::tag('dt', 'Email');
echo Html::tag('dd', Html::a($model->user->username,
    Yii::t('app', 'mailto:{0}<{1}>', [$model->fullName, $model->user->username])));

foreach ($model->attributes as $name => $value) {
    echo Html::tag('dt', $model->getAttributeLabel($name));
    if (in_array($name, $datesAttr)) {
        $value = $formatter->asDate($value, 'dd.MM.Y, HH:mm:ss xxx');
    }
    if ($name == 'phone') {
        $value = Html::a($value, Yii::t('app', 'tel:+{0}', $value));
    }
    echo Html::tag('dd', $value);
}
echo Html::endTag('dl');