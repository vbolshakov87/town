<?php
/**
 * Привязка личностей к странам
 * @property Country $country
 * @property Figure $figure
 */
class LinkFigureCountry extends BaseLinkFigureCountry
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkFigureCountry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'figure' => array(self::BELONGS_TO, 'Figure', 'figure_id'),
		);
	}
} 