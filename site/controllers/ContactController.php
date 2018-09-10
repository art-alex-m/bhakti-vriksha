<?php
/**
 * ContactController.php
 *
 * Created by PhpStorm.
 * @date 24.08.18
 * @time 15:01
 */

namespace app\controllers;

use app\models\ContactForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Class ContactController
 *
 * Контроллер обратной связи
 *
 * @package app\controllers
 * @since 1.0.0
 */
class ContactController extends Controller
{
    public $defaultAction = 'create';

    /**
     * Создает обращение
     * @return string
     */
    public function actionCreate()
    {
        $contact = new ContactForm([
            'bodyTpl' => '/contact/contactMail',
        ]);

        if ($contact->load(Yii::$app->request->post()) && $contact->send()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Your request has been sent'));
            return $this->refresh();
        }

        return $this->render('form', ['model' => $contact]);
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
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ]);
    }
}