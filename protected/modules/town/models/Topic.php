<?php
/**
 * Темы для выбора участниками
 * @property UserGroup $userGroup
 */
class Topic extends BaseTopic
{
	const STATUS_NEW = 'new';
	const STATUS_UNDERWAY = 'underway';
	const STATUS_DONE = 'done';

	public static $statusList = array('new' => 'Новый', 'underway' => 'В разработки','done' => 'Готово');

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Topic the static model class
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
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Тема',
			'create_time' => 'Создана',
			'update_time' => 'Изменена',
			'user_group_id' => 'Группа',
			'booked_time' => 'Дата выбора',
			'status' => 'Статус',
		);
	}


	public static function getStatusLabel($status)
	{
		return self::$statusList[$status];
	}
} 