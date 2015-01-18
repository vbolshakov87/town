<?php
/**
 * Привязка личностей к наградам
 * @property Award $award
 * @property Figure $figure
 */
class LinkFigureAward extends BaseLinkFigureAward
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkFigureAward the static model class
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
			'award' => array(self::BELONGS_TO, 'Award', 'award_id'),
			'figure' => array(self::BELONGS_TO, 'Figure', 'figure_id'),
		);
	}
} 