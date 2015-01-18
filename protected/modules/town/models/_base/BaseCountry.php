<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property integer $id_country
 * @property string $name_country
 * @property string $alt_name_country
 * @property integer $count
 * @property integer $ord
 * @property integer $view
 *
 * The followings are the available model relations:
 * @property LinkFigureCountry[] $linkFigureCountries
 */
class BaseCountry extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCountry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('count, ord, view', 'numerical', 'integerOnly'=>true),
			array('name_country, alt_name_country', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_country, name_country, alt_name_country, count, ord, view', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'linkFigureCountries' => array(self::HAS_MANY, 'LinkFigureCountry', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_country' => 'Id Country',
			'name_country' => 'Name Country',
			'alt_name_country' => 'Alt Name Country',
			'count' => 'Count',
			'ord' => 'Ord',
			'view' => 'View',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_country',$this->id_country);
		$criteria->compare('name_country',$this->name_country,true);
		$criteria->compare('alt_name_country',$this->alt_name_country,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('ord',$this->ord);
		$criteria->compare('view',$this->view);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}