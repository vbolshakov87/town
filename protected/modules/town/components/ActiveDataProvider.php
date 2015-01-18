<?php
/**
 * CActiveDataProvider с ограничением по количеству записей
 *
 */

class ActiveDataProvider extends CActiveDataProvider
{
	public $useCache = false;
	public $cacheKey = null;
	public $cacheTime = null;
	public $cacheDependency = null;

	public $pageVar = 'pager';

	public $countLimit = null;
	
	
	/**
	 * Подсчет числа записей. Если установлено свойство useCache, то вначале проверяем кэш
	 * @return integer
	 */
	protected function calculateTotalItemCount()
	{
		if (!$this->useCache) {
			return $this->calculateTotalItemCountWithLimit();
		}
		else {
			$countCacheKey = $this->cacheKey . '_count';
			$count = Yii::app()->getCache()->get($countCacheKey);
			if ($count === false) {
				$count = $this->calculateTotalItemCountWithLimit();
				Yii::app()->getCache()->set($countCacheKey, $count, $this->cacheTime, $this->cacheDependency);
			}
			return $count;
		}
	}
	
	
	/**
	 * Подсчет числа записей с учетом максимального порога. Если установлено свойство countLimit, то вначале проверяем существование записи с отступом countLimit
	 * Если такая запись существует, то принимаем общее кол-во записей равное лимиту
	 * Если запись не существует, то считаем реальное кол-во записей. 
	 * Если свойство countLimit не установлено, то сразу считаем реальное количество записей
	 * @return integer
	 */
	protected function calculateTotalItemCountWithLimit()
	{
		if(!is_null($this->countLimit)) {
			$criteria = $this->getCriteria();
			$criteria->offset = $this->countLimit;
			$criteria->limit = 1;
			if($this->model->find($criteria)) {
				return $this->countLimit;
			}
			else {
				return parent::calculateTotalItemCount();
			}
		}
		else {
			return parent::calculateTotalItemCount();
		}
	}
	

	protected function fetchData()
	{
	//	return parent::fetchData();
		if (!$this->useCache) {
			return parent::fetchData();
		}
		else {

			$criteria=clone $this->getCriteria();
			if(($pagination=$this->getPagination())!==false)
			{
				$pagination->setItemCount($this->getTotalItemCount());
				$pagination->applyLimit($criteria);
			}

			$listCacheKey = $this->cacheKey . '_list';
			$data = Yii::app()->getCache()->get($listCacheKey);
			if ($data === false) {
				$data = parent::fetchData();
				Yii::app()->getCache()->set($listCacheKey, $data, $this->cacheTime, $this->cacheDependency);
			}

			return $data;
		}
	}


	public function getPagination($className='CPagination')
	{
		$pagination = parent::getPagination($className);
		$pagination->pageVar = $this->pageVar;

		return $pagination;
	}

	

}
