<?php
/**
 * Выпадающий список категорий проекта
 */
class CategoryMenuWidget extends CWidget
{
	public $type;
	protected $_data;

	public function init()
	{
		$modelClass = ucfirst($this->type).'Rubric';
		$dataModels = ActiveRecord::model($modelClass)->findAll(
			array(
				'select' => 't.title, t.id',
				'order' => 't.title ASC',
				'scopes' => array('active'),
			)
		);
		foreach ($dataModels as $dataModel) {
			$this->_data[] = array(
				'id' => $dataModel->id,
				'title' => $dataModel->title
			);
		}
	}


	public function run()
	{
		$this->render('_CategoryMenuWidget', array(
			'type' => $this->type,
			'data' => $this->_data,
			'activeRubric' => Yii::app()->getRequest()->getParam('rubricId', null),
		));
	}
} 