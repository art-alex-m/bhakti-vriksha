<?php
/**
 * User.php
 *
 * Created by PhpStorm.
 * @date 21.08.18
 * @time 11:16
 */

namespace app\components;

/**
 * Class User
 *
 * Расширение функционала \yii\web\User
 *
 * @package app\components
 * @since 1.0.0
 */
class User extends \yii\web\User
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            LoginStatBehavior::class,
        ]);
    }
}