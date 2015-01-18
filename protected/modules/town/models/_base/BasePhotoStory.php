<?php

/**
 * This is the model class for table "photo_story".
 *
 * The followings are the available columns in table 'photo_story':
 * @property integer $id
 * @property string $title
 * @property string $brief
 * @property string $content
 * @property string $tags
 * @property integer $date_begin
 * @property integer $date_end
 * @property string $image
 * @property string $coordinates
 * @property integer $active
 * @property integer $main_page
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $user_group_id
 * @property integer $rubric_id
 * @property integer $hits
 * @property integer $visits
 * @property string $image_top_1
 * @property string $image_top_3
 * @property integer $number_of_votes
 * @property double $weight
 * @property string $image_sidebar
 * @property integer $show_in_sidebar
 */
class BasePhotoStory extends PublicationActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo_story';
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
			array('date_begin, date_end, active, main_page, create_time, update_time, user_group_id, rubric_id, hits, visits, number_of_votes, show_in_sidebar', 'numerical', 'integerOnly'=>true),
			array('weight', 'numerical'),
			array('title, image, coordinates, image_top_1, image_top_3, image_sidebar', 'length', 'max'=>256),
			array('brief, content, tags', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, brief, content, tags, date_begin, date_end, image, coordinates, active, main_page, create_time, update_time, user_group_id, rubric_id, hits, visits, image_top_1, image_top_3, number_of_votes, weight, image_sidebar, show_in_sidebar', 'safe', 'on'=>'search'),
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
			'coordinates' => 'Coordinates',
			'active' => 'Active',
			'main_page' => 'Main Page',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'user_group_id' => 'User Group',
			'rubric_id' => 'Rubric',
			'hits' => 'Количество просмотров детальной страницы',
			'visits' => 'Visits',
			'image_top_1' => 'Image Top 1',
			'image_top_3' => 'Image Top 3',
			'number_of_votes' => 'Number Of Votes',
			'weight' => 'Weight',
			'image_sidebar' => 'Image Sidebar',
			'show_in_sidebar' => 'Show In Sidebar',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('brief',$this->brief,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('date_begin',$this->date_begin);
		$criteria->compare('date_end',$this->date_end);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('coordinates',$this->coordinates,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('main_page',$this->main_page);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('user_group_id',$this->user_group_id);
		$criteria->compare('rubric_id',$this->rubric_id);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('visits',$this->visits);
		$criteria->compare('image_top_1',$this->image_top_1,true);
		$criteria->compare('image_top_3',$this->image_top_3,true);
		$criteria->compare('number_of_votes',$this->number_of_votes);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('image_sidebar',$this->image_sidebar,true);
		$criteria->compare('show_in_sidebar',$this->show_in_sidebar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BasePhotoStory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
