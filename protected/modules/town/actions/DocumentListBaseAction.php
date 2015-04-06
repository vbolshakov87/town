<?php

/**
 * Class DocumentListBaseAction
 * @property $modelClass Document
 */
abstract class DocumentListBaseAction extends CAction
{
	public $limit = null;
	public $modelClass = 'Document';
	public $view = 'index';
	public $viewPaging = 'paging';
	public $cacheTime = 604800;

	protected $_usedIds = array();
	protected $_offset = 0;
	protected $_page = 0;
	protected $_countAll = 0;
	protected $_rubricId = null;
	protected $_items = array();


	protected function _init()
	{
		if (is_null($this->limit))
			$this->limit = Yii::app()->params['limitOnPage'];


		if (empty($this->_usedIds))
			$this->_usedIds = Yii::app()->params['alreadyUsedIds'];

		$this->_page = intval(Yii::app()->getRequest()->getParam('page', 1));

		$this->_rubricId = Yii::app()->getRequest()->getParam('rubricId', null);
		if ($this->_rubricId != intval($this->_rubricId))
			$this->_rubricId = null;

		$this->_offset = $this->limit*($this->_page-1);

		$cacheKey = json_encode(
			array(
				get_class($this),
				get_class($this->getController()),
				$this->modelClass,
				$this->_page,
				$this->limit,
				$this->_rubricId
			)
		);

		$data = Yii::app()->getCache()->get($cacheKey);
		if ($data === false) {

			$this->_countAll = $this->_getCountAll();

			/** @var Document[] $data */
			$this->_items = ActiveRecord::model($this->modelClass)->findAll($this->_getCriteria());

			$cacheKeys = array('story_all');
			foreach ($this->_items as $item) {
				$cacheKeys[] = Story::cacheKey($item->id);
			}

			$cacheDependency = new CacheTaggedDependency($cacheKeys);

			Yii::app()->getCache()->set(
				$cacheKey,
				array(
					'countAll' => $this->_countAll,
					'items' => $this->_items
				),
				$this->cacheTime,
				$cacheDependency
			);
		}
		else {
			$this->_countAll = $data['countAll'];
			$this->_items = $data['items'];
		}

	}

	public function run()
	{
		$this->_init();

		$remains = $this->_countAll-count($this->_items)-$this->_offset;

		if (Yii::app()->getRequest()->isAjaxRequest) {
			$itemsView = $this->getController()->renderPartial($this->viewPaging, array(
				'items' => $this->_items,
			), true);

			echo json_encode(array(
				'items' => $itemsView,
				'countRemains' => $remains,
				'page' => $this->_page,
				'pageText' => 'Еще '.$remains.' '. ChoiceFormat::format(array('статья', 'статьи', 'статей'), $remains),
			));
			Yii::app()->end();
		}
		else {
			$this->getController()->render($this->view, array(
				'countRemains' => $remains,
				'items' => $this->_items,
				'limit' => $this->limit,
				'countAll' => $this->_countAll,
				'page' => $this->_page,
			));
		}
	}


	abstract protected function _getCountAll();


	/**
	 * @return CDbCriteria
	 */
	protected function _getBaseCriteria()
	{
		$criteria = new CDbCriteria(array(
			'order' => 't.create_time DESC',
			'limit' => $this->limit,
			'offset' => $this->_offset,
		));

		if (!empty($this->_usedIds))
			$criteria->addNotInCondition('t.id', $this->_usedIds);

		return $criteria;
	}


	protected function _getCriteria()
	{
		return $this->_getBaseCriteria();
	}
}