<?php
/**
 * Аутификация пользователя по email
 */
class UserIdentityByEmailPassword extends CBaseUserIdentity {

	protected $_userEmail = '';
	protected $_userId = 0;
	protected $_userName = '';
	protected $_userPassword = '';


	public function __construct($userEmail, $userPassword)
	{
		$this->_userEmail = $userEmail;
		$this->_userPassword = $userPassword;
	}


	public function authenticate()
	{
		/* @var $user User */
		$userCriteria = new CDbCriteria(array(
			'scopes' => array('active'),
		));
		$user = User::model()->findByAttributes(array('email'=>$this->_userEmail), $userCriteria);

		if(empty($user)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif(!$user->validatePassword($this->_userPassword)) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else {
			$this->errorCode=self::ERROR_NONE;
			$this->_userId = $user->id;
			$this->_userName = $user->name;
		}

		return !$this->errorCode;
	}


	public function getId()
	{
		return $this->_userId;
	}


	public function getName()
	{
		return $this->_userName;
	}
}