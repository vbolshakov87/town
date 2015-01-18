<?php
/**
 * Статистика просмотра сайта
 */
class AllStatWidget extends CWidget
{

	protected $_data;

	public function init()
	{
		$cacheKey = get_class($this);

		$data = Yii::app()->getCache()->get($cacheKey);

		if ($data === false) {
			$this->_data['readerCount'] = Story::model()->active()->sum('hits') + PhotoStory::model()->active()->sum('hits') + Figure::model()->active()->sum('hits');
			$this->_data['authorCount'] = User::model()->active()->count();
			$this->_data['postCount'] = Story::model()->active()->count() + PhotoStory::model()->active()->count() + Figure::model()->active()->count();

			Yii::app()->cache->set($cacheKey, $this->_data, 60*10);
		}
		else {
			$this->_data = $data;
		}
	}


	public function run()
	{
		$this->render('_AllStatWidget', $this->_data);
	}
} 