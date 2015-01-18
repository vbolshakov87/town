<?php
/**
 * @property string $name
 * @property string $email
 * @property int $is_activated
 */
class WebTownUser extends CWebUser
{

	protected $_user = null;
	protected $_userGroupsAvailable = null;
	protected $_sessionPrefix = 'ps_';

	public function init()
	{
		parent::init();
	}


	/**
	 * Добавление нужный данных в сессию после логина
	 * @param $fromCookie
	 */
	protected function afterLogin($fromCookie)
	{
		/** @var User $user */
		$user = User::model()->findByPk($this->getId());

		// добавляем в сессию часто используемые поля
		$this->setState('name', $user->name);
		$this->setState('email', $user->email);
		$this->setState('is_activated', 1);

	}


	protected function afterLogout()
	{
		// очищаем объект пользователя
		if(!is_null($this->_user))
			$this->_user = null;
	}


	/**
	 * Получение данных пользователя
	 * @return User
	 */
	public function getUser()
	{
		if ( is_null($this->_user) ) {
			if (!($this->isGuest)) {
				$this->_user = User::model()->with(array('linkUserGroupUsers'))->together()->findByPk($this->getId());
			}
			else {
				$this->_user = array();
			}
		}

		return $this->_user;
	}



	/**
	 * Проверка на админа
	 * @return bool
	 */
	public function isAdmin()
	{
		$user = $this->getUser();
		foreach ($user->linkUserGroupUsers as $linkUserGroup) {
			if ($linkUserGroup->user_group_id == UserGroup::GROUP_ADMIN)
				return true;
		}

		return false;
	}


	public function hasAdminAccess()
	{
		//if ($this->isAdmin())
		//	return true;

		$groups = $this->getAvailableGroups();

		foreach ($groups as $group) {
			if ($group['id'] != UserGroup::GROUP_SITE)
				return true;
		}

		return false;
	}

	/**
	 * Получение данных из сессии
	 * @param $key
	 * @return array
	 */
	public function readFromSession($key)
	{
		$session = Yii::app()->session;
		$key = $this->_sessionPrefix.$key;
		return !empty($session[$key]) ? $session[$key] : array();
	}


	/**
	 * Запись данных в сессию
	 * @param $key
	 * @param $val
	 */
	public function writeIntoSession($key, $val)
	{
		$key = $this->_sessionPrefix.$key;
		Yii::app()->session[$key] = $val;
	}


	public function getAvailableGroups()
	{
		if ($this->_userGroupsAvailable === null) {
			$userGroupCriteria = new CDbCriteria(array(
				'order' => 't.id ASC'
			));
			if (!$this->isAdmin()) {
				$userGroupCriteria->scopes['scopeAvailableForUserGroups'] = array('userId' => $this->getId());
			}
			$userGroups = UserGroup::model()->findAll($userGroupCriteria);

			$userGroupArr = array();
			foreach ($userGroups as $userGroup) {
				$userGroupArr[$userGroup->id] = $userGroup->attributes;
			}

			$this->_userGroupsAvailable = $userGroupArr;
		}

		return $this->_userGroupsAvailable;
	}


	public function getAvailableGroupsDropDown()
	{
		$userGroupArr = $this->getAvailableGroups();

		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}

		return $userGroupArrDropDown;
	}


	public function updateRatedDocuments($modelClass, $id)
	{
		$ratedDocumentsArr = $this->getRatedDocuments();

		if (count($ratedDocumentsArr) > 200)
			$ratedDocumentsArr = array();

		$ratedDocumentsArr[] = $modelClass.$id;

		$options = array(
			'domain' => '.' . str_replace(array('http://', 'https://'), '', Yii::app()->getRequest()->getHostInfo()),
			'path' => '/',
			'expire' => time()+60*60*24*180,
		);

		Yii::app()->request->cookies['ratedDocuments'] = new CHttpCookie('ratedDocuments', implode(',', $ratedDocumentsArr), $options);
	}


	public function getRatedDocuments()
	{
		return explode(',', Yii::app()->request->cookies['ratedDocuments']);
	}


	public function isRatedDocument($modelClass, $id)
	{
		return in_array($modelClass.$id, $this->getRatedDocuments());
	}
}
