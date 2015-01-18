<?php

/**
 * Class DocumentListAction
 * Список документов на главной странице
 */
class DocumentListAction extends DocumentListBaseAction
{
	/**
	 * Всего документов
	 * @return int
	 */
	protected function _getCountAll()
	{
		return Document::model()->count();
	}
} 