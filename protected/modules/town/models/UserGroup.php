<?php
/**
 * Группы пользователей
 * @method UserGroup active()
 * @property Figure[] $figures
 * @property LinkUserGroupUser[] $linkUserGroupUsers
 * @property PhotoStory[] $photoStories
 * @property Story[] $stories
 * @property Topic[] $topics
 */
class UserGroup extends BaseUserGroup
{
	const GROUP_ADMIN = 1;
	const GROUP_SITE = 100;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserGroup the static model class
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
			'figures' => array(self::HAS_MANY, 'Figure', 'user_group_id'),
			'linkUserGroupUsers' => array(self::HAS_MANY, 'LinkUserGroupUser', 'user_group_id'),
			'photoStories' => array(self::HAS_MANY, 'PhotoStory', 'user_group_id'),
			'stories' => array(self::HAS_MANY, 'Story', 'user_group_id'),
			'topics' => array(self::HAS_MANY, 'Topic', 'user_group_id'),
		);
	}


	public function scopes()
	{
		$tableAlias = $this->getTableAlias(false, false);
		return array(
			'active' => array(),
		);
	}


	public function scopeAvailableForUserGroups($userId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'with' => array('linkUserGroupUsers' => array(
				'joinType' => 'inner join',
			)),
			'condition' => 'linkUserGroupUsers.user_id = :user_id AND linkUserGroupUsers.user_group_id != :group_site',
			'params' => array(
				':user_id' => $userId,
				':group_site' => UserGroup::GROUP_SITE,
		)));

		return $this;
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('name, code', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'code' => 'Код',
		);
	}
} 