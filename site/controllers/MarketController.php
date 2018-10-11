<?php
/**
 * MarketController.php
 *
 * Created by PhpStorm.
 * @date 03.09.18
 * @time 16:52
 */

namespace app\controllers;

use yii\filters\AccessControl;
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

    /**
     * Отображение демонстрационной статистики по рынку святого имени
     * @return string
     */
    public function actionDemo()
    {
        return $this->render('demo');
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'demo'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ]);
    }
}