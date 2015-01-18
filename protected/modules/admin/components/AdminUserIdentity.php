<?php
/**
 * Аутификация пользователя
 */
class AdminUserIdentity extends UserIdentity
{

	/**
	 * Аутификация пользователя
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/* @var $member User */
		$member = User::model()->active()->findByAttributes(array('login' => $this->username));
		if(empty($member)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}

		Yii::app()->userGroup->setUser($member->id);

		// если пользователь не входит в группы, которым доступна админка
		if (!Yii::app()->userGroup->hasAdminAccess()) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		if($member->hashed_password != $this->_getHashedPassword()) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else {
			$this->errorCode=self::ERROR_NONE;
			$this->_userId = $member->id;
		}

		return !$this->errorCode;
	}

}
