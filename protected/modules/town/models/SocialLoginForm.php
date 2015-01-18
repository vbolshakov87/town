<?php
/**
 * Форма авторизации через email при
 * регистрации через социальную сеть
 */
class SocialLoginForm extends CFormModel
{
	public $email;
	protected $_identity;


	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			// rememberMe needs to be a boolean
			array('email', 'emailValid'),
			array('email', 'email'),
		);
	}


	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Ваш email'
		);
	}


	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentityByEmail($this->email);
			if(!$this->_identity->authenticate())
				$this->addError('email','Пользователь с таким email не найден в базе.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentityByEmail($this->email);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration= 3600*24*30; // 30 days
			Yii::app()->getUser()->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}


	/**
	 * Проверка уникальности email
	 * @return bool
	 */
	public function isUniqueEmail()
	{
		$memberCount = User::model()->countByAttributes(array('email'=>$this->email));

		if ($memberCount == 0) {
			return true;
		}
		else {
			$this->addError('email','Пользователь с таким email уже существует.');
			return false;
		}
	}


	/**
	 * Проверка email на валидность
	 * @return bool
	 */
	public function emailValid()
	{
		if (!empty($this->errors))
			return false;

		if (
			preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$this->email)
		) {
			return true;
		}
		else {
			$this->addError('email','email указан не корректно.');
			return false;
		}
	}
}