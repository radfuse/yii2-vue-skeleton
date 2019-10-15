<?php

namespace app\controllers;

use Yii;
use app\components\RestController;
use app\models\LoginForm;
use app\models\RegisterForm;

/**
 * Site controller
 */
class SiteController extends RestController
{
	/** @var array */
	protected $_noAuthActions = ['login', 'register'];

	/**
	 * Action for logging in
	 * @return array
	 */
	public function actionLogin()
	{
		$model = new LoginForm();

		if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
			$user = $model->getUser();

			return [
				'status' => 200,
				'success' => true,
				'access_token' => $user->getAuthKey(),
				'user' => [
					'username' => $user->username
				],
			];
		}
		else {
			$model->validate();
			return $model;
		}
	}
    
    /**
     * Action for registering
     * @return array
     */
	public function actionRegister(){
        $model = new RegisterForm();
        
		if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->signup())
			return ['success' => 1];
        else {
			$model->validate();
			return $model;
		}
    }

	/**
	 * Ping for server availability
	 * @return array
	 */
	public function actionPing()
	{
		return ['pong' => 1];
	}
}
