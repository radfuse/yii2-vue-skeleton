<?php
namespace app\components;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

/**
 * Base controller class for API
 */
class RestController extends Controller
{
	/** @inheritdoc */
	public $enableCsrfValidation = false;
	/** @var array Action IDs that does not require authentication */
	protected $_noAuthActions = [];
	
	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
		$behaviors = parent::behaviors();
		$vuePort = Yii::$app->params['vue-port'];

		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];

		unset($behaviors['authenticator']);
		
		$behaviors['corsFilter'] = [
			'class' => \app\components\Cors::className(),
			'cors'  => [
				'Origin' => ["http://localhost:{$vuePort}"],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
			],
		];

        $behaviors['authenticator'] = [
			'class' => HttpBearerAuth::className(),
			'except' => array_merge(['options'], $this->_noAuthActions)
		];
		
		return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}
