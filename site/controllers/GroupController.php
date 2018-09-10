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
use app\rbac\Permissions;
use app\models\User;
use app\models\UserToLeader;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
                ->joinWith('profile')
                ->joinWith('residence')
                ->leftJoin(['u2l' => UserToLeader::tableName()], 'users.id = u2l."userId"')
                ->andWhere(['=', 'u2l.leaderId', $user->id]),
            'sort' => [
                'attributes' => [
                    'id',
                    'residence.title',
                    'createdAt',
                    'profile.fullName' => [
                        'asc' => [
                            'profile.lastName' => SORT_ASC,
                            'profile.firstName' => SORT_ASC,
                            'profile.parentName' => SORT_ASC,
                        ],
                        'desc' => [
                            'profile.lastName' => SORT_DESC,
                            'profile.firstName' => SORT_DESC,
                            'profile.parentName' => SORT_DESC,
                        ],
                    ],
                ],
                'defaultOrder' => ['profile.fullName' => SORT_ASC],
            ]
        ]);
        return $this->render('list', ['model' => $provider]);
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
                        'actions' => ['list'],
                        'roles' => [Permissions::PERMISSION_GROUP_LIST],
                    ],
                ]
            ]
        ]);
    }
}