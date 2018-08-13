<?php
/**
 * ActivityController.php
 *
 * Created by PhpStorm.
 * @date 29.08.18
 * @time 10:32
 */

namespace app\controllers;

use app\components\GetAuthUserTrait;
use app\rbac\Permissions;
use app\models\Statistics;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Class ActivityController
 *
 * Контроллер просмотра активности действий пользователя на сайте
 *
 * @package app\controllers
 * @since 1.0.0
 */
class ActivityController extends Controller
{
    use GetAuthUserTrait;

    /**
     * Просмотр статистики действий авторизованного пользователя списком
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        Yii::$app->setTimeZone('Europe/Moscow');
        $user = $this->getAuthUser();
        $provider = new ActiveDataProvider([
            'query' => Statistics::find()->andWhere(['=', 'userId', $user->id])->limit(10),
            'sort' => ['defaultOrder' => ['createdAt' => SORT_DESC]],
            'pagination' => false,
        ]);
        return $this->render('index', ['model' => $provider]);
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
                        'roles' => [Permissions::PERMISSION_ACTIVITY_VIEW],
                    ]
                ]
            ]
        ]);
    }
}