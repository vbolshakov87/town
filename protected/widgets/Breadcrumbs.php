<?php

Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Хлебная крошка
 */
class Breadcrumbs extends CBreadcrumbs
{
	public function run()
	{
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=strtr($this->activeLinkTemplate,array(
				'{url}'=>CHtml::normalizeUrl(Yii::app()->homeUrl),
				'{label}'=>Yii::t('zii','Home'),
			));
		elseif($this->homeLink!==false)
			$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode(Yii::app()->homeUrl) : Yii::app()->homeUrl,$this->inactiveLinkTemplate);

		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
					'{url}'=>CHtml::normalizeUrl($url),
					'{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
		}
		echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}

} 