<?php
Yii::import('zii.widgets.CMenu');
/**
 * Top menu widget
 */
class NavMenuWidget extends CMenu
{
	public $htmlOptions;

	public $items;

	protected function renderMenu($items)
	{
		if(count($items))
		{
			echo CHtml::openTag('nav',$this->htmlOptions)."\n";
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('nav');
		}
	}


	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
            $item['menu_id'] = 'top-menu'.$count;

			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}


			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

		}
	}


	protected function renderMenuItem($item)
	{
		$linkControllerArr = explode('/',$item['url'][0]);
		$linkControllerId = $linkControllerArr[0];

		if ($linkControllerId == $this->getController()->id)
			$item['active'] = 1;

		if (!empty($item['active'])) {
			if (empty($item['linkOptions']['class']))
				$item['linkOptions']['class'] = '';

			$item['linkOptions']['class'] .= ' '.'active';

            $item['linkOptions']['id'] = $item['menu_id'];
		}



		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			return CHtml::link(CHtml::tag('span',array(),$label),$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else {
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
		}
	}


}