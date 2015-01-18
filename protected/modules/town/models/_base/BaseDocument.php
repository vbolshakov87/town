<?php

/**
 * This is the model class for table "document".
 *
 * The followings are the available columns in table 'document':
 * @property integer $id
 * @property string $title
 * @property string $brief
 * @property string $content
 * @property string $tags
 * @property string $image
 * @property integer $main_page
 * @property integer $create_time
 * @property integer $update_time
 * @property string $essence
 * @property integer $essence_id
 */
class BaseDocument extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseDocument the static model class
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
		return 'document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, essence_id', 'required'),
			array('main_page, create_time, update_time, essence_id', 'numerical', 'integerOnly'=>true),
			array('title, image', 'length', 'max'=>256),
			array('essence', 'length', 'max'=>11),
			array('brief, content, tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, brief, content, tags, image, main_page, create_time, update_time, essence, essence_id', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'brief' => 'Brief',
			'content' => 'Content',
			'tags' => 'Tags',
			'image' => 'Image',
			'main_page' => 'Main Page',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'essence' => 'Essence',
			'essence_id' => 'Essence',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('brief',$this->brief,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('main_page',$this->main_page);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('essence',$this->essence,true);
		$criteria->compare('essence_id',$this->essence_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}