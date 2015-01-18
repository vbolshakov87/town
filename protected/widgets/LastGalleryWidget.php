<?php

/**
 * Class LastGalleryWidget
 * Превью последней фотогалереи
 */
class LastGalleryWidget extends CWidget
{
	protected $_cacheKey = null;
	protected $_cacheData = null;
	protected $_data = null;

	public function init()
	{
		$this->_cacheKey = json_encode(array(
			'LastGalleryWidget'
		));

		$this->_cacheData = Yii::app()->getCache()->get($this->_cacheKey);
		if ($this->_cacheData === false) {
			$criteria = new CDbCriteria(array(
				'scopes' => array('active'),
				'order' => 't.show_in_sidebar DESC, t.create_time DESC',
				'limit' => 5,
				'condition' => '(t.image != \'\' OR t.image_sidebar != \'\')'
			));


			/** @var PhotoStory[] $data */
			$data = PhotoStory::model()->findAll($criteria);

			$cachePhotoTags = array('photo_story_all');
			$getByShowInSideBar = false;
			foreach ($data as $k => $item) {

				$cachePhotoTags[] = PhotoStory::cacheKey($item->id);

				if (!empty($item->show_in_sidebar))
					$getByShowInSideBar = true;

				if ($getByShowInSideBar === true && empty($item->show_in_sidebar))
					unset($data[$k]);
			}

			$cacheDependency = new CacheTaggedDependency($cachePhotoTags);
			Yii::app()->getCache()->set($this->_cacheKey, $data, 60*60*24, $cacheDependency);

			$this->_cacheData = $data;

		}
	}


	public function run()
	{
		if (!empty($this->_cacheData))
			$this->render('_LastGalleryWidget', array('data' => $this->_cacheData[rand(0,count($this->_cacheData)-1)]));
	}
} 