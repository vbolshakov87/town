<?php
/**
 * Виджет селекта секций каталога
 */
class TreeSectionWidget extends CWidget
{
	public $printSetsTree = null;
	public $attribute; // по какому полю
	public $model = null; // ActiveRecord
	public $levelDelimiter = '-';
	public $topLevelLabel = 'Верхний уровень';
	public $htmlOptions = array(
		'class' => 'form-control'
	);

	protected $_data = array();

	public function init()
	{
		$this->_data = array(
			0 => $this->topLevelLabel,
 		);

		$this->_fillData($this->printSetsTree);
	}


	protected function _fillData($printSetsTree)
	{
		foreach ($printSetsTree as $element) {

			if ($element['id'] == $this->model->{$this->attribute})
				continue;

			$delimiter = str_repeat( $this->levelDelimiter, $element['level']-1);
			if (!empty($delimiter)) $delimiter .= ' ';

			$this->_data[$element['id']] = $delimiter . $element['name'];
			if (!empty($element['children'])) {
				$this->_fillData($element['children']);
			}
		}
	}


	public function run()
	{
		echo Html::activeDropDownList($this->model, $this->attribute, $this->_data, $this->htmlOptions);
	}
}