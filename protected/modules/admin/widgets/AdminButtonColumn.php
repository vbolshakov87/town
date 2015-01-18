<?php
Yii::import('zii.widgets.grid.CButtonColumn');
/**
 * Кнопки действий в админке
 */
class AdminButtonColumn extends CButtonColumn
{
	public $viewButtonOptions = array('class'=>'view', 'target'=>'_blank');
	public $htmlOptions = array('width'=>'75px');


	protected function renderButton($id,$button,$row,$data)
	{
		if ($id == 'delete' && !Yii::app()->getUser()->getUser()->isGroupAdmin())
			return false;

		if($id == 'update' && isset($data->user_group_id) && !in_array($data->user_group_id, array_keys(Yii::app()->getUser()->getAvailableGroups())))
			return false;

		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
			return false;

		parent::renderButton($id, $button, $row, $data);
	}

} 