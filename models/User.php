<?php

namespace app\models;

use Yii;

/**
 * User indentity class
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_at
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'create';

    /** @var string Plain password. Used for model validation. */
    public $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
				'class' => \yii\behaviors\TimestampBehavior::className(),
				'createdAtAttribute' => 'created_at',
				'updatedAtAttribute' => 'updated_at',
			],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'on' => self::SCENARIO_CREATE],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_EDIT],
            [['status', 'created_at', 'updated_at', 'last_login_at'], 'integer'],
            [['username', 'password', 'email', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email', 'username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($insert)
            $this->setAttribute('auth_key', Yii::$app->security->generateRandomString());

        if (!empty($this->password))
            $this->setAttribute('password_hash', Yii::$app->security->generatePasswordHash($this->password));

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->getAttribute('auth_key');
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') === $authKey;
    }

    /**
     * Returns user by username
     * @param string $username
     * @return User|boolean
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
