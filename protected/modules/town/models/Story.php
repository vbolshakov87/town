<?php
/**
 * Модель историй (статьи)
 * @property UserGroup $userGroup
 * @property StoryRubric $rubric
 * @property LinkUserGroupUser[] $linkUserGroups
 * @property GalleryPhoto[] $gallery
 * @method Story active()
 * @method Story mainPage()
 */
class Story extends BaseStory
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Story the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		$rules = parent::rules();
	//	$rules[] = array('image', 'file', 'allowEmpty' => true);
		return $rules;
	}



	public function relations()
	{
		return array(
			'linkUserGroups' => array(self::BELONGS_TO, 'LinkUserGroupUser', array('user_group_id'=>'user_group_id')),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
			'rubric' => array(self::BELONGS_TO, 'StoryRubric', 'rubric_id'),
			'gallery' => array(self::HAS_MANY, 'GalleryPhoto', 'essence_id', 'on' => 'gallery.essence = "story"'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'brief' => 'Описание для списка',
			'content' => 'Описание',
			'tags' => 'Теги',
			'date_begin' => 'Начало',
			'date_end' => 'Окончание',
			'image' => 'Изображение',
			'image_top_1' => 'Изображение 300x189',
			'image_top_3' => 'Изображение 630x391',
			'active' => 'На сайте',
			'main_page' => 'Выводить на главной странице',
			'create_time' => 'Создано',
			'update_time' => 'Обновлено',
			'user_group_id' => 'Работает группа',
			'rubric_id' => 'Рубрика',
		);
	}


	public function scopes()
	{
		$tableAlias = $this->getTableAlias(false, false);
		return array(
			'active' => array(
				'condition' => $tableAlias.'.active = 1',
			),
			'mainPage' => array(
				'condition' => $tableAlias.'.main_page = 1'
			),
		);
	}


	public static function cacheKey($id)
	{
		return __CLASS__.'_'.$id;
	}
} 