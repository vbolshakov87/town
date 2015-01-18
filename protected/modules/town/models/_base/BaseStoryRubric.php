<?php

/**
 * This is the model class for table "story_rubric".
 *
 * The followings are the available columns in table 'story_rubric':
 * @property integer $id
 * @property string $title
 * @property string $brief
 * @property integer $active
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $user_group_id
 *
 * The followings are the available model relations:
 * @property UserGroup $userGroup
 */
class BaseStoryRubric extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseStoryRubric the static model class
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
		return 'story_rubric';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, user_group_id', 'required'),
			array('active, create_time, update_time, user_group_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('brief', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, brief, active, create_time, update_time, user_group_id', 'safe', 'on'=>'search'),
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
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'user_group_id'),
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
			'active' => 'Active',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'user_group_id' => 'User Group',
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
		$criteria->compare('active',$this->active);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('user_group_id',$this->user_group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}