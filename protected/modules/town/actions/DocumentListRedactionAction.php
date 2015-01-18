<?php

/**
 * Class DocumentListRedactionAction
 * Общий action для story, photoStory, figure
 */
class DocumentListRedactionAction extends DocumentListBaseAction
{
	public $modelClass = 'PhotoStory';

	/**
	 * Всего документов
	 * @return int
	 */
	protected function _getCountAll()
	{
		return ActiveRecord::model($this->modelClass)->active()->scopeRubric($this->_rubricId)->count();
	}


	/**
	 * CDbCriteria выборки документов
	 * @return CDbCriteria
	 */
	protected function _getCriteria()
	{
		$criteria = $this->_getBaseCriteria();
		$criteria->scopes[] = 'active';
		$criteria->scopes['scopeRubric'] =  array('rubricId' => $this->_rubricId);
		return $criteria;
	}
} 