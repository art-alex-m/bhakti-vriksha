<?php
/**
 * index.php
 *
 * Просмотр информации о системе
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 10:17
 * @since 1.0.0
 */

use yii\bootstrap\Html;

$this->title = 'О системе';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2', $this->title);

?>
<br>
<p style="font-size: 14pt;">Название системы: <b><?= Yii::$app->name ?></b></p>
<p style="font-size: 13pt;">Версия системы: <b><?= Yii::$app->version ?></b></p>
<p>Версия PHP: <b><?= PHP_VERSION ?></b></p>
<p>Версия Yii: <b><?= Yii::getVersion() ?></b></p>
<p>Драйвер базы данных: <b><?= Yii::$app->db->getDriverName() ?></b></p>
<p>Версия базы данных: <b><?= Yii::$app->db->getServerVersion() ?></b></p>
