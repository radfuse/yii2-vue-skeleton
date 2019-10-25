<?php

namespace app\controllers;

use Yii;
use app\components\RestController;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use yii\web\UnauthorizedHttpException;
use yii\web\BadRequestHttpException;

/**
 * Site controller
 */
class SiteController extends RestController
{
	/** @var array */
	protected $authOptional = ['login', 'register', 'refresh-token'];

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
				'access_token' => $user->access_token,
				'refresh_token' => $user->refresh_token,
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
	public function actionRegister()
	{
        $model = new RegisterForm();
        
		if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->signup())
			return ['success' => 1];
        else {
			$model->validate();
			return $model;
		}
    }
    
    /**
     * Action for refreshing access token
	 * @throws BadRequestHttpException
	 * @throws UnauthorizedHttpException
     * @return array
     */
	public function actionRefreshToken()
	{
		$refreshToken = Yii::$app->getRequest()->getBodyParams('refresh_token');
		$accessToken = Yii::$app->getRequest()->getBodyParams('access_token');

		if (!$refreshToken || !$accessToken)
			throw new BadRequestHttpException('Missing `refresh_token` or `access_token` parameters.');
		
		if (!($user = User::findIdentityByRefreshToken($refreshToken)))
			throw new UnauthorizedHttpException('No user found for refresh token.');

		if (!$user->isTokenValid('refresh_token'))
			throw new UnauthorizedHttpException('Refresh token expired.');

		$user->generateTokens();
		if ($user->save(false, ['access_token', 'refresh_token']))
			return [
				'status' => 200,
				'success' => true,
				'access_token' => $user->access_token,
				'refresh_token' => $user->refresh_token,
			];
		else
			return [
				'status' => 200,
				'success' => false,
			];
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
