<?php
/**
 * AboutController.php
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 10:15
 */

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AboutController
 *
 * Просмотр информации о системе
 *
 * @package app\controllers
 * @since 1.0.0
 */
class AboutController extends Controller
{
    /**
     * Просмотр информации о системе
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ]);
    }
}