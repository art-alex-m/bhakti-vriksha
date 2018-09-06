<?php
/**
 * MarketController.php
 *
 * Created by PhpStorm.
 * @date 03.09.18
 * @time 16:52
 */

namespace app\controllers;

use yii\web\Controller;

/**
 * Class MarketController
 *
 * Контроллер отображения статистики показателей по рынку святого имени
 *
 * @package app\controllers
 * @since 1.0.0
 */
class MarketController extends Controller
{
    /**
     * Отображение графиков статистики по рынку статистики святого имени
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}