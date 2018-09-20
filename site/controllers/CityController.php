<?php
/**
 * CityController.php
 *
 * Created by PhpStorm.
 * @date 20.09.18
 * @time 19:55
 */

namespace app\controllers;

use app\models\City;
use app\models\Residence;
use app\rbac\Permissions;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class CityController
 * CRUD операции над объектами городов City
 * @package app\controllers
 * @since 1.0.0
 */
class CityController extends Controller
{
    /**
     * Просмотр записей городов списком
     * @return string
     */
    public function actionIndex()
    {
        $query = City::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]],
        ]);
        return $this->render('index', ['provider' => $provider]);
    }

    /**
     * Создает новую запись города
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new City();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success',
                Yii::t('app', 'Model "{0}" was created', $model->title));
            return $this->redirect(['/city/']);
        }

        return $this->render('model', ['model' => $model]);
    }

    /**
     * Обновляет запись по идентификатору
     *
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = null;
        try {
            $model = City::findOne($id);
        } catch (\Exception $e) {
        }

        if (!$model instanceof City) {
            throw new NotFoundHttpException(
                Yii::t('app', 'Model not found by id #{id}', ['id' => $id]));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success',
                Yii::t('app', 'Model "{0}" was updated', $model->title));
            return $this->redirect(['/city/']);
        }

        return $this->render('model', ['model' => $model]);
    }

    /**
     * Удаляет запись по идентификатору
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = null;
        try {
            $model = City::findOne($id);
        } catch (\Exception $e) {
        }

        if (!$model instanceof City) {
            throw new NotFoundHttpException(
                Yii::t('app', 'Model not found by id #{id}', ['id' => $id]));
        }

        $check = Residence::findOne(['cityId' => $id]);

        if ($check instanceof Residence) {
            $model->status = City::STATUS_ARCHIVE;
            $model->save(false);
            Yii::$app->session->addFlash('warning', sprintf('%s. %s',
                Yii::t('app', 'Model "{0}" could not be deleted', $model->title),
                Yii::t('app', 'Model "{0}" was archived', $model->title)
            ));
        } else {
            $model->delete();
            Yii::$app->session->addFlash('success',
                Yii::t('app', 'Model "{0}" was deleted', $model->title));
        }

        return $this->redirect(['/city/']);
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
                        'roles' => [Permissions::PERMISSION_CITY_LIST],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [Permissions::PERMISSION_CITY_CREATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [Permissions::PERMISSION_CITY_UPDATE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [Permissions::PERMISSION_CITY_DELETE],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ]);
    }
}