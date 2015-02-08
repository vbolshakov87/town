<?php
/**
 * Модель выдающихся личностей
 * @property UserGroup $userGroup
 * @property LinkFigureAward[] $linkFigureAwards
 * @property LinkFigureCountry[] $linkFigureCountries
 * @property LinkUserGroupUser[] $linkUserGroups
 * @property GalleryPhoto[] $gallery
 * @method Figure active()
 * @method Figure mainPage()
 */
class Figure extends BaseFigure
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Figure the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function relations()
	{
		return array(
			'linkUserGroups' => array(self::BELONGS_TO, 'LinkUserGroupUser', array('user_group_id'=>'user_group_id')),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
			'linkFigureAwards' => array(self::HAS_MANY, 'LinkFigureAward', 'figure_id'),
			'linkFigureCountries' => array(self::HAS_MANY, 'LinkFigureCountry', 'figure_id'),
			'gallery' => array(self::HAS_MANY, 'GalleryPhoto', 'essence_id', 'on' => 'gallery.essence = "figure"'),
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
			'image' => 'Основное изображение',
			'image_top_1' => 'Изображение 300x189',
			'image_top_3' => 'Изображение 630x391',
			'active' => 'Активность',
			'main_page' => 'Выводить на главной странице',
			'create_time' => 'Создано',
			'update_time' => 'Обновлено',
			'user_group_id' => 'Работает группа',
			'rubric_id' => 'Рубрика',
			'place_of_birth' => 'Место рождения',
			'date_of_birth' => 'Дата рождения',
			'date_of_death' => 'Дата смерти',
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