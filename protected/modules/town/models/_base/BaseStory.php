<?php

/**
 * This is the model class for table "story".
 *
 * The followings are the available columns in table 'story':
 * @property integer $id
 * @property string $title
 * @property string $brief
 * @property string $content
 * @property string $tags
 * @property integer $date_begin
 * @property integer $date_end
 * @property string $image
 * @property string $image_top_1
 * @property string $image_top_3
 * @property integer $active
 * @property integer $main_page
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $user_group_id
 * @property integer $rubric_id
 * @property integer $hits
 * @property integer $visits
 * @property double $weight
 * @property integer $number_of_votes
 */
class BaseStory extends PublicationActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseStory the static model class
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
		return 'story';
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
			array('date_begin, date_end, active, main_page, create_time, update_time, user_group_id, rubric_id, hits, visits, number_of_votes', 'numerical', 'integerOnly'=>true),
			array('weight', 'numerical'),
			array('title, image, image_top_1, image_top_3', 'length', 'max'=>256),
			array('brief, content, tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, brief, content, tags, date_begin, date_end, image, image_top_1, image_top_3, active, main_page, create_time, update_time, user_group_id, rubric_id, hits, visits, weight, number_of_votes', 'safe', 'on'=>'search'),
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
			'date_begin' => 'Date Begin',
			'date_end' => 'Date End',
			'image' => 'Image',
			'image_top_1' => 'Image Top 1',
			'image_top_3' => 'Image Top 3',
			'active' => 'Active',
			'main_page' => 'Main Page',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'user_group_id' => 'User Group',
			'rubric_id' => 'Rubric',
			'hits' => 'Hits',
			'visits' => 'Visits',
			'weight' => 'Weight',
			'number_of_votes' => 'Number Of Votes',
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
		$criteria->compare('date_begin',$this->date_begin);
		$criteria->compare('date_end',$this->date_end);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_top_1',$this->image_top_1,true);
		$criteria->compare('image_top_3',$this->image_top_3,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('main_page',$this->main_page);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('user_group_id',$this->user_group_id);
		$criteria->compare('rubric_id',$this->rubric_id);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('visits',$this->visits);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('number_of_votes',$this->number_of_votes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}