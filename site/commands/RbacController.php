<?php
/**
 * RbacController.php
 *
 * Created by PhpStorm.
 * @date 07.09.18
 * @time 20:37
 */

namespace app\commands;

use app\rbac\RbacSystemInit;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class RbacController
 *
 * Развертывает систему ролевого доступа
 *
 * @package app\controllers
 * @since 1.0.0
 */
class RbacController extends Controller
{
    /**
     * Развертывает систему ролевого доступа
     * @return int
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $model = new RbacSystemInit();
        $model->start();
        $this->stdout('RBAC system was successfully initialize' . PHP_EOL);
        return ExitCode::OK;
    }
}