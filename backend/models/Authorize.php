<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
/**
 * Login form
 */
class Authorize extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getAdmin();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * login_user - фронтенд, login_admin - бэкенд
     *
     * @return boolean whether the user is logged in successfully
     */

    public function login_admin()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getAdmin()
    {
        if ($this->_user === null) {
            $this->_user = User::findByAdmin($this->username);
        }

        return $this->_user;
    }

    public static function isAdmin($username)
    {
        if (User::findByAdmin($username))
        {
            return true;
        } else {
            return false;
        }
    }
}
