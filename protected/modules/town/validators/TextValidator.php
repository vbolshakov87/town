<?php
/**
 * валидация текстовых полей
 */
class TextValidator extends CValidator
{

	protected function validateAttribute($object, $attribute)
	{
		if(!empty($object->{$attribute}) && !preg_match('~^([а-яa-z0-9\ \\ \/])+$~ui', $object->{$attribute})) {
			$this->addError($object, $attribute, 'Формат не верный');
		}
	}
}
