<?php
/**
 * Модель фото событий
 * @property UserGroup $userGroup
 * @property PhotoStoryRubric $rubric
 * @property LinkUserGroupUser[] $linkUserGroups
 * @property GalleryPhoto[] $gallery
 * @method PhotoStory active()
 * @method PhotoStory mainPage()
 */
class PhotoStory extends BasePhotoStory
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PhotoStory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('image, image_top_1, image_top_3, image_sidebar', 'file', 'allowEmpty' => true);
		return $rules;
	}


	public function relations()
	{
		return array(
			'linkUserGroups' => array(self::BELONGS_TO, 'LinkUserGroupUser', array('user_group_id'=>'user_group_id')),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
			'rubric' => array(self::BELONGS_TO, 'PhotoStoryRubric', 'rubric_id'),
			'gallery' => array(self::HAS_MANY, 'GalleryPhoto', 'essence_id', 'on' => 'gallery.essence = "photo_story"'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' =>  Yii::t('PhotoStory', 'Title'),
			'brief' => Yii::t('PhotoStory', 'Brief'),
			'content' => Yii::t('PhotoStory', 'Content'),
			'tags' => Yii::t('PhotoStory', 'Tags'),
			'date_begin' => Yii::t('PhotoStory', 'Date begin'),
			'date_end' => Yii::t('PhotoStory', 'Date end'),
			'image' => Yii::t('PhotoStory', 'Image'),
			'image_top_1' => Yii::t('PhotoStory', 'Image 300x189'),
			'image_top_3' => Yii::t('PhotoStory', 'Image 630x391'),
			'active' => Yii::t('PhotoStory', 'Active'),
			'main_page' => Yii::t('PhotoStory', 'In main page'),
			'create_time' => Yii::t('PhotoStory', 'Create time'),
			'update_time' => Yii::t('PhotoStory', 'Update time'),
			'user_group_id' => Yii::t('PhotoStory', 'User group'),
			'rubric_id' => Yii::t('PhotoStory', 'Rubric'),
			'image_sidebar' => Yii::t('PhotoStory', 'Image  in sidebar'),
			'show_in_sidebar' => Yii::t('PhotoStory', 'Show in sidebar'),
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


	public function getEssence()
	{
		return 'photo_story';
	}
} 