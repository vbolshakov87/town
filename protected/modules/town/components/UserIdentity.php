<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	protected $_userId = 0;

	/**
	 * Аутификация пользователя
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$member = Member::model()->active()->findByAttributes(array('login' => $this->username));

		if(empty($member)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else if($member->hashed_password != $this->_getHashedPassword()) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else {
			$this->errorCode=self::ERROR_NONE;
			$this->_userId = $member->id;
		}

		return !$this->errorCode;
	}

	public function _getHashedPassword()
	{
		return md5($this->password);
	}


	public function getId()
	{
		return $this->_userId;
	}

}