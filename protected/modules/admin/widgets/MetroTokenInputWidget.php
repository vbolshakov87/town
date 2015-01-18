<?php

Yii::import('application.extensions.tokeninput.TokenInput');

/**
 * Выбор станций метро
 */
class MetroTokenInputWidget extends TokenInput
{
    public $model; // модель для которой проставляем станции метро
	public $attribute; // название поля в форме
	
	
	public $url = array('ajax/MetroAutoComplete');
				

	protected $_stations = array();


	public function init()
	{

		$stations = $this->model->metroStation;
		if(!empty($stations))
		{
			foreach($stations as $item)
			{
				$this->_stations[] = $item->dataForAutoComplete();
			}
		}
		
		$this->options = array(
					'allowCreation' => false,
					'minChars' => 2,
					'hintText' => false,
					'noResultsText' => 'станции не найдены',
					'searchingText' => 'ищем...',
					'preventDuplicates' => true,
					'resultsFormatter' => 'js:function(item){ return "<li><p><div class=\"circle\" style=\"background:#" + item.color + "\"></div>" + item.name + " (" + item.city + ", " + item.line_name + ")</p></li>" }',
					'tokenFormatter' => 'js:function(item){ return "<li rel=\"" + item.id + "\"><p><div class=\"circle\" style=\"background:#" + item.color + "\"></div>" + item.name + "</p></li>" }',
					'theme' => 'facebook',
					'prePopulate' => $this->_stations,
				);
		
		parent::init();
	}

}