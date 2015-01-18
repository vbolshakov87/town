<?php
/**
 * Привязка пользователя к группе
 * @property User $user
 * @property UserGroup $userGroup
 */
class LinkUserGroupUser extends BaseLinkUserGroupUser
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseLinkUserGroupUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
		);
	}
} 