<?php
/**
 * валидация номера телефона
 */
class PhoneValidator extends CValidator
{

	protected function validateAttribute($object, $attribute)
	{
		if (!empty($object->{$attribute}) && !preg_match('~^[0-9\-\(\)\#\+\ ]+$~', $object->{$attribute})) {
			$this->addError($object, $attribute, 'Телефон заполнен некорректно');
			return false;
		}
	}
}
