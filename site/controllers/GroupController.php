<?php
/**
 * GroupController.php
 *
 * Created by PhpStorm.
 * @date 28.08.18
 * @time 13:15
 */

namespace app\controllers;

use app\components\GetAuthUserTrait;
use app\models\User;
use app\models\UserToLeader;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

/**
 * Class GroupController
 *
 * Контроллер по управению группой
 *
 * @package app\controllers
 * @since 1.0.0
 */
class GroupController extends Controller
{
    use GetAuthUserTrait;

    public $defaultAction = 'list';

    /**
     * Просмотр членов группы списком
     * @return string
     * @throws \Throwable
     */
    public function actionList()
    {
        Yii::$app->setTimeZone('Europe/Moscow');
        $user = $this->getAuthUser();
        $provider = new ActiveDataProvider([
            'query' => User::find()
                ->with('profile')
                ->leftJoin(['u2l' => UserToLeader::tableName()], 'users.id = u2l."userId"')
                ->andWhere(['=', 'u2l.leaderId', $user->id]),
        ]);
        return $this->render('list', ['model' => $provider]);
    }
}