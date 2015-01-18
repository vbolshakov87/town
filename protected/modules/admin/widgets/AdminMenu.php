<?php
Yii::import('zii.widgets.CMenu');

class AdminMenu extends CMenu
{
	public $submenuHtmlOptions = array('class'=>'dropdown-menu');
	public $htmlOptions = array('class' => 'nav navbar-nav');
	public $activeCssClass = 'active';
	public $itemCssClass = 'dropdown';
	public $activateParents = true;


	protected function renderMenuItem($item) {

		if(isset($item['url'])) {

			if($this->linkLabelWrapper === null){
				$label = $item['label'];
			}
			else{
				$label = CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			}

			if (!empty($item['items'])) {
				return '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$label.' <b class="caret"></b></a>';
			}

			return CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else {
			if(isset($item['label'])){
				return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
			}
		}

	}


}