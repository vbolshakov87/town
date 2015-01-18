<?php
/**
 * Вывод блока контента редактируемого в админке
 */
class ContentBlockWidget extends CWidget
{

	protected $_data;
	public $name;

	public function init()
	{
		$cacheKey = json_encode(array(
			get_class($this),
			$this->name
		));

		$data = Yii::app()->getCache()->get($cacheKey);

		if ($data === false) {

			/** @var ContentBlock $data */
			$data = ContentBlock::model()->findByAttributes(array('name' => $this->name));
			if (!empty($data)) {
				$this->_data = $data->text;
			}

			$cacheDependency = new CacheTaggedDependency(array($this->name));

			Yii::app()->cache->set($cacheKey, $this->_data, 60*60*24*30, $cacheDependency);
		}
		else {
			$this->_data = $data;
		}
	}


	public function run()
	{
		echo $this->_data;
	}


} 