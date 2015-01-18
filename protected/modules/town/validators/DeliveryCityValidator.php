<?php
/**
 * валидатор города доставки и самовывоза
 */
class DeliveryCityValidator extends CValidator
{

	protected function validateAttribute($object, $attribute)
	{
		
		if($object->delivery_type == 'delivery')  {
			if(!in_array($object->{$attribute}, array_keys(CanvasPrintOrder::getCitiesListForDropDownList()))) {
				$this->addError($object, $attribute, 'Не указан город');
			}
			if(empty($object->delivery_address)){
				$this->addError($object, 'delivery_address', 'Не указан адрес');
			}
		}
		else {
			if(!in_array($object->{$attribute}, array_keys(CanvasPrintOrder::getCitiesListForDropDownList(true)))) {
				$this->addError($object, $attribute, 'Не указан город');
			}
			
		}
		
		return true;
	}
}
