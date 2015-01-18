<?php
/**
 * Аутификация пользователя по id
 */
class UserIdentityById extends CUserIdentity
{
	protected $_userId = 0;
	protected $_userName = '';


	public function __construct($userId)
	{
		$this->_userId = $userId;
	}


	public function authenticate()
	{
		/* @var $user User */
		$user = User::model()->active()->findByPk($this->_userId);

		if(empty($user)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
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