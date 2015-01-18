<?php
/**
 * Модель лога действий публикатора
 * @property User $user
 */
class UserActionLog extends BaseUserActionLog
{

	const ACTION_CREATE = 'creat';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';
	const ACTION_READ = 'read';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserActionLog the static model class
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
		);
	}


	public static function addToLog($page, $pageItemId, $action)
	{

	}
} 