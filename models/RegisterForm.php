<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * RegisterForm is the model behind the register form
 */
class RegisterForm extends Model
{
    /** @var string */
    public $username;
    /** @var string */
    public $email;
    /** @var string */
    public $password;
    /** @var string */
    public $password_again;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_again'], 'required'],
            [['username', 'email'], 'trim'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            [['username', 'email'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6],
            ['password_again', 'string', 'min' => 6],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
	public function validatePassword($attribute, $params){
        if ($this->password != $this->password_again) {
            $this->addError('password_again', 'Passwords do not match');
        }
    }

    /**
     * Signs user up
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate())
            return null;
        
        $user = new User();
        $user->scenario = User::SCENARIO_CREATE;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $this->password;

        if ($user->save())
            return $user;

        return null;
    }
}
