<?php
/**
 * MyController.php
 *
 * Created by PhpStorm.
 * @date 23.08.18
 * @time 10:36
 */

namespace app\controllers;

use yii\web\Controller;

/**
 * Class MyController
 *
 * Контроллер личного кабинета
 *
 * @package app\controllers
 * @since 1.0.0
 */
class MyController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['/japa/index']);
    }
}