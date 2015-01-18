<?php
/**
 * Модель фотогалереи для сущностей (figure, story, photo_story)
 */
class GalleryPhoto extends BaseGalleryPhoto
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GalleryPhoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'create_time' => 'Создано',
			'update_time' => 'Обновлено',
			'original_name' => 'Original Name',
			'mimetype' => 'Mimetype',
			'type' => 'Type',
			'width' => 'Width',
			'height' => 'Height',
			'essence' => 'Essence',
			'essence_id' => 'Essence',
			'image' => 'Image',
			'sort' => 'Sort',
		);
	}
} 