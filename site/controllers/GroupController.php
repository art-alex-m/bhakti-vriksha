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
        Yii::$app->user->setReturnUrl(['/group/']);

        $user = $this->getAuthUser();
        $provider = new ActiveDataProvider([
            'query' => User::find()
                ->alias('u')
                ->joinWith('profile')
                ->joinWith('city city')
                ->leftJoin(['u2l' => UserToLeader::tableName()], 'u.id = u2l."userId"')
                ->andWhere(['=', 'u2l.leaderId', $user->id])
                ->andWhere(['=', 'u.status', User::STATUS_ACTIVE]),
            'sort' => [
                'attributes' => [
                    'id',
                    'city.title',
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