<?php
/**
 * Авторизацния в админке
 */
class AdminLoginForm extends CFormModel
{
	public $login;
	public $password;
	public $rememberMe;

	private $_identity;

	public function rules()
	{
		return array(
			// username and password are required
			array('login, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Запомнить',
			'login'=>'Логин',
			'password'=>'Пароль',
		);
	}


	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new AdminUserIdentity($this->login,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Не корректный логин или пароль.');
		}
	}


	/**
	 * Логин пользователя
	 * @return bool
	 */
	public function login()
	{
		if($this->_identity===null) {
			$this->_identity=new AdminUserIdentity($this->login,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
			$duration=$this->rememberMe ? 3600*24*30 : 3600;
			//if (PS_DEBUG == true)
			//$duration = 0;
			Yii::app()->getUser()->login($this->_identity,$duration);
			return true;
		}
		else {
			return false;
		}
	}
}