<?php
/**
 * Аутификация пользователя по email
 */
class UserIdentityByEmail extends CBaseUserIdentity {

	protected $_userEmail = '';
	protected $_userId = 0;
	protected $_userName = '';


	public function __construct($userEmail)
	{
		$this->_userEmail = $userEmail;
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