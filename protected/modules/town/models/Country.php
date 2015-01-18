<?php
/**
 * модель Стран
 * @property LinkFigureCountry[] $linkFigureCountries
 */
class Country extends BaseCountry
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function relations()
	{
		return array(
			'linkFigureCountries' => array(self::HAS_MANY, 'LinkFigureCountry', 'country_id'),
		);
	}
} 