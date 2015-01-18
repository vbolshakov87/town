<?php

/**
 * This is the model class for table "editor_photo".
 *
 * The followings are the available columns in table 'editor_photo':
 * @property integer $id
 * @property integer $member_id
 * @property integer $photo_id
 * @property integer $ctime
 * @property integer $utime
 * @property integer $publication_time
 * @property integer $approved
 * @property string $page
 * @property integer $photo_day
 */
class BaseEditorPhoto extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseEditorPhoto the static model class
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
		return 'editor_photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, photo_id', 'required'),
			array('member_id, photo_id, ctime, utime, publication_time, approved, photo_day', 'numerical', 'integerOnly'=>true),
			array('page', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, member_id, photo_id, ctime, utime, publication_time, approved, page, photo_day', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'photo_id' => 'Photo',
			'ctime' => 'Ctime',
			'utime' => 'Utime',
			'publication_time' => 'Publication Time',
			'approved' => 'Approved',
			'page' => 'Page',
			'photo_day' => 'Photo Day',
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
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('photo_id',$this->photo_id);
		$criteria->compare('ctime',$this->ctime);
		$criteria->compare('utime',$this->utime);
		$criteria->compare('publication_time',$this->publication_time);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('page',$this->page,true);
		$criteria->compare('photo_day',$this->photo_day);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}