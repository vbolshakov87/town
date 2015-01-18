<?php

/**
 * This is the model class for table "gallery_photo".
 *
 * The followings are the available columns in table 'gallery_photo':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $create_time
 * @property integer $update_time
 * @property string $original_name
 * @property string $mimetype
 * @property string $type
 * @property integer $width
 * @property integer $height
 * @property string $essence
 * @property integer $essence_id
 * @property string $image
 * @property integer $sort
 */
class BaseGalleryPhoto extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseGalleryPhoto the static model class
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
		return 'gallery_photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, essence_id', 'required'),
			array('create_time, update_time, width, height, essence_id, sort', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('original_name, mimetype', 'length', 'max'=>100),
			array('type', 'length', 'max'=>3),
			array('essence', 'length', 'max'=>11),
			array('image', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, create_time, update_time, original_name, mimetype, type, width, height, essence, essence_id, image, sort', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'original_name' => 'Original Name',
			'mimetype' => 'Mimetype',
			'type' => 'Type',
			'width' => 'Width',
			'height' => 'Height',
			'essence' => 'Essence',
			'essence_id' => 'Essence',
			'image' => 'Image',
			'sort' => 'Sort',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('original_name',$this->original_name,true);
		$criteria->compare('mimetype',$this->mimetype,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('essence',$this->essence,true);
		$criteria->compare('essence_id',$this->essence_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}