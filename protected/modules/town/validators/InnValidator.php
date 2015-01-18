<?php
/**
 * валидация ИНН
 */
class InnValidator extends CValidator
{

	protected function validateAttribute($object, $attribute)
	{
		$inn = (string) $object->{$attribute};
		//ИНН должен содержать только цифровые данные
		if(!empty($inn)) {
			if(!preg_match('~^([0-9])+$~ui', $inn)) {
				$this->addError($object, $attribute, 'Неверный формат');
			}

			$length = mb_strlen($inn);
			//в ИНН может быть либо 10 либо 12 цифр
			if($length != 10 && $length !=12) {
				$this->addError($object, $attribute, 'Неверный формат');
			}
			if($length == 10) {
				$num9 = (string) (((
							2*$inn[0] + 4*$inn[1] + 10*$inn[2] +
							3*$inn[3] + 5*$inn[4] +  9*$inn[5] +
							4*$inn[6] + 6*$inn[7] +  8*$inn[8]
						) % 11) % 10);
				if($inn[9] !== $num9) {
					$this->addError($object, $attribute, 'Неверный формат');
				}
			}
			elseif($length == 12 ) {
				$num10 = (string) (((
							7*$inn[0] + 2*$inn[1] + 4*$inn[2] +
							10*$inn[3] + 3*$inn[4] + 5*$inn[5] +
							9*$inn[6] + 4*$inn[7] + 6*$inn[8] +
							8*$inn[9]
						) % 11) % 10);

				$num11 = (string) (((
							3*$inn[0] +  7*$inn[1] + 2*$inn[2] +
							4*$inn[3] + 10*$inn[4] + 3*$inn[5] +
							5*$inn[6] +  9*$inn[7] + 4*$inn[8] +
							6*$inn[9] +  8*$inn[10]
						) % 11) % 10);

				if(!($inn[11] === $num11 && $inn[10] === $num10)) {
					$this->addError($object, $attribute, 'Неверный формат');
				}
			}
		}
	}
}
