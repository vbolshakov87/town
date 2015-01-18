<?php
/**
 * Html is a static class that provides a collection of helper methods for creating HTML views.
 */
class Html extends CHtml
{
	
	/**
	 * возвращает width="" height="" для вставки в тег <img> пропорционально уменьшенных относительно оригинального размера
	 * @param int $width ширина оригинального изображение
	 * @param int $height высота оригинального изображения
	 * @param int $maxWidth максимальная ширина
	 * @param int $maxHeight максимальная высота
	 * @return string
	 */
	public static function getImageMaxWidthHeight($width, $height, $maxWidth, $maxHeight)
	{
		if($width < $maxWidth && $height < $maxHeight)
		{
			return "width='{$width}' height='{$height}'";
		}
		
		if($width > $height && $width/$height >= $maxWidth/$maxHeight)
		{
			$w = $maxWidth;
			$h = round($height * $maxWidth / $width);
		}
		else
		{
			$h = $maxHeight;
			$w = round($width * $maxHeight / $height);
		}
		
		return "width='{$w}' height='{$h}'";
	}


	public static function getUserGroupListForDropDown($all = false)
	{
		/** @var UserGroup $groups */
		$groups = UserGroup::model()->active()->findAll(array('select' => 't.id, t.name'));
		$groupArr = array();

		if ($all == true)
			$groupArr[] = 'Все';

		foreach ($groups as $group) {
			$groupArr[$group->id] = $group->name;
		}

		return $groupArr;
	}

}
