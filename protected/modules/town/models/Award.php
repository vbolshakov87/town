<?php
/**
 * Награды личностей
 * The followings are the available columns in table 'award':
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $icon
 * @property string $small_icon
 * @property string $content
 *
 * The followings are the available model relations:
 * @property LinkFigureAward[] $linkFigureAwards
 */
class Award extends BaseAward
{

	/**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return Award the static model class
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
			'linkFigureAwards' => array(self::HAS_MANY, 'LinkFigureAward', 'award_id'),
		);
	}

} 