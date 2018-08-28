<?php
/**
 * JapaController.php
 *
 * Created by PhpStorm.
 * @date 23.08.18
 * @time 16:11
 */

namespace app\controllers;

use app\components\ActiveRecord;
use app\components\GetAuthUserTrait;
use app\models\Japa;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class JapaController
 *
 * Контроллер личного кабинета по управлению статистикой джапы
 *
 * @package app\controllers
 * @since 1.0.0
 */
class JapaController extends Controller
{
    use GetAuthUserTrait;

    /**
     * Отображает список статистики по чтению кругов джапы
     *
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        Yii::$app->setTimeZone('Europe/Moscow');
        $japa = new ActiveDataProvider([
            'query' => $this->getAuthUser()->getJapa(),
            'sort' => ['defaultOrder' => ['createdAt' => SORT_DESC]],
        ]);

        $lastTime = $this->getLastJapaTime();
        $dayNextMonth = $lastTime->modify('first day of next month 00:00:00');
        $now = new \DateTime();

        $diff = $dayNextMonth->diff($now);

        return $this->render('index', [
            'model' => $japa,
            'newJapa' => $this->checkNewJapa(),
            'japaTime' => $diff,
        ]);
    }

    /**
     * Создает новую запись статистики по джапе
     * @return string|\yii\web\Response
     * @throws \Throwable
     */
    public function actionCreate()
    {
        if (!$this->checkNewJapa()) {
            Yii::$app->session->addFlash('warning',
                Yii::t('app', 'This month the data has already been entered'));
            return $this->redirect(['/japa/']);
        }

        $user = $this->getAuthUser();
        $lastTime = $this->getLastJapaTime();
        $dayNextMonth = $lastTime->modify('first day of next month 00:00:00')->modify('+14 days');
        $now = new \DateTime();

        if ($now->format('m') == $dayNextMonth->format('m')) {
            $dayNextMonth = $now;
        }

        $date = $dayNextMonth->format(\DateTime::RFC3339_EXTENDED);
        $japa = new Japa([
            'userId' => $user->id,
            'createdAt' => $date,
        ]);
        $japa->on(ActiveRecord::EVENT_BEFORE_INSERT, function ($event) use ($date) {
            $event->sender->createdAt = $date;
        });

        if ($japa->load(Yii::$app->request->post()) && $japa->save()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Add new japa entry'));
            return $this->redirect(['/japa/']);
        }

        return $this->render('form', [
            'model' => $japa,
        ]);
    }

    /**
     * Обновляет запись джапы по идентификатору
     *
     * @param string $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $japa = null;
        try {
            $japa = Japa::findOne($id);
        } catch (\Exception $e) {
        }

        if (!$japa) {
            throw new NotFoundHttpException(Yii::t('app', 'Model not found by id #{id}',
                ['id' => Html::encode($id)]));
        }

        if ($japa->load(Yii::$app->request->post()) && $japa->save()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Japa entry {d} was updated', [
                'd' => (new \DateTime($japa->createdAt))->format('d-m-Y'),
            ]));
            return $this->redirect(['/japa/']);
        }

        return $this->render('form', [
            'model' => $japa,
        ]);
    }

    /**
     * Просмотр статистики джапы пользователя
     *
     * @param int $id Идентификатор пользователя системы
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = User::findOne($id);
        if (!$user instanceof User) {
            throw new NotFoundHttpException(Yii::t('app', 'Model not found by id #{id}',
                ['id' => $id]));
        }

        Yii::$app->setTimeZone('Europe/Moscow');
        $japa = new ActiveDataProvider([
            'query' => Japa::find()->andWhere(['=', 'userId', $id]),
            'sort' => ['defaultOrder' => ['createdAt' => SORT_DESC]],
        ]);
        return $this->render('view', [
            'model' => $japa,
            'user' => $user,
        ]);
    }

    /**
     * Проверяет, что есть возможность ввода джапы в текущем месяце
     *
     * @return bool
     * @throws \Throwable
     */
    protected function checkNewJapa()
    {
        $lastTime = $this->getLastJapaTime()->modify('first day of next month 00:00:00');
        $now = new \DateTime();
        $diff = $now->getTimestamp() - $lastTime->getTimestamp();
        return $diff > 0;
    }

    /**
     * Время создания последней записи статистики по джапе
     * @return \DateTime
     * @throws \Throwable
     */
    protected function getLastJapaTime()
    {
        $lastJapa = $this->getLastJapa();
        $lastTime = $lastJapa
            ? new \DateTime($lastJapa->createdAt)
            : (new \DateTime())->modify('-1 month');

        return $lastTime;
    }

    /**
     * Возвращает запись о последней записи джапы пользователя
     *
     * @return Japa|null
     * @throws \Throwable
     */
    protected function getLastJapa()
    {
        $user = $this->getAuthUser();
        /** @var Japa|null $lastJapa */
        $lastJapa = $user->getJapa()->one();
        return $lastJapa;
    }
}