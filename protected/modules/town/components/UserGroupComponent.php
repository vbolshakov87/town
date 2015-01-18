<?php
/**
 * Группы пользователей
 */
class UserGroupComponent extends CComponent
{
	protected $_groups = null;
	protected $_userId = null;

	public function init()
	{
		if (!Yii::app()->getUser()->isGuest)
			$this->_userId = Yii::app()->getUser()->getId();

		/** @var UserGroup[] $groups */
		$groups = UserGroup::model()->active()->together()->with('linkUserGroupUsers')->findAll();
		foreach ($groups as $group) {
			$groupUsers = $group->linkUserGroupUsers;
			$this->_groups[$group->code] = array();
			foreach ($groupUsers as $groupUser) {
				$this->_groups[$group->code][] = $groupUser->user_id;
			}
		}
	}


	public function setUser($userId)
	{
		$this->_userId = $userId;
	}


	public function isInGroup($group)
	{
		if (!isset($this->_groups[$group])) {
			throw new CException('Группа не существует');
		}


		if ($group != 'admin')
			return $this->isAdmin() || in_array($this->_userId, $this->_groups[$group]);
		else
			return in_array($this->_userId, $this->_groups[$group]);
	}


	public function isAdmin()
	{
		return $this->isInGroup('admin');
	}


	public function hasAdminAccess()
	{
		if (
			$this->isInGroup('licey86')
		)
			return true;

		return false;
	}

}