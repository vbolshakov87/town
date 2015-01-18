<?php
/**
 * Рубрики фотоисторий
 * @property UserGroup $userGroup
 * @property PhotoStory[] $photoStories
 * @method PhotoStoryRubric active()
 */
class PhotoStoryRubric extends BasePhotoStoryRubric
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoryRubric the static model class
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
			'photoStories' => array(self::HAS_MANY, 'PhotoStory', 'rubric_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'brief' => 'Описание',
			'active' => 'Активность',
			'create_time' => 'Создано',
			'update_time' => 'Обновлено',
			'user_group_id' => 'Работает группа',
		);
	}


	public function scopes()
	{
		$tableAlias = $this->getTableAlias(false, false);
		return array(
			'active' => array(
				'condition' => $tableAlias.'.active = 1',
			),
		);
	}
} 