<?php
namespace app\components;

use Yii;

/**
 * CORS component for API
 */
class Cors extends \yii\filters\Cors
{
    /**
     *{@inheritdoc}
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT HEAD');
            Yii::$app->end();
        }

        return true;
    }
}