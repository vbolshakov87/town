<?php
/**
 * Вывод главных записей на сайте
 */
class TopDocumentsWidget extends CWidget
{
	protected $_documents;
	public $limit = 3;
	public $columns = 3;
	public $view = '3columns';
	public $type = null;


	public function init()
	{
		$alreadyUsedIds = Yii::app()->params['alreadyUsedIds'];
		$cacheKey = json_encode(array(get_class($this), $this->limit, $alreadyUsedIds, $this->type));
		$this->_documents = Yii::app()->getCache()->get($cacheKey);
		if ($this->_documents === false) {
			$criteria = new CDbCriteria(array(
				'limit' => $this->limit,
				'condition' => 't.image != "" ',
				'order' => 't.create_time DESC',
				'scopes' => array('mainPage'),
			));

			if (!empty($this->type)) {
				$criteria->addCondition('t.essence = :essence');
				$criteria->params[':essence'] = $this->type;
			}

			if (!empty($alreadyUsedIds)) {
				$criteria->addNotInCondition('t.id', $alreadyUsedIds);
			}

			$this->_documents = Document::model()->findAll($criteria);

			$cacheTagArr = array();
			/** @var $document Document */
			foreach ($this->_documents as $document) {
				$cacheTagArr[] = Document::cacheKey($document->essence, $document->essence_id);
			}

			$cacheDependency = new CacheTaggedDependency($cacheTagArr);
			Yii::app()->getCache()->set($cacheKey, $this->_documents, 60*61, $cacheDependency);
		}

		// save information about already used ids on this page
		$ids = Yii::app()->params['alreadyUsedIds'];
		foreach ($this->_documents as $document) {
			$ids[] = $document->id;
		}
		Yii::app()->getParams()->add('alreadyUsedIds', $ids);
	}


	public function run()
	{
		$this->render('_TopDocumentsWidget/'.$this->view, array('documents' => $this->_documents, 'columns' => $this->columns));
	}
} 