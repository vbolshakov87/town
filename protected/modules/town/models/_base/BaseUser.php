<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $login
 * @property string $hashed_password
 * @property string $email
 * @property string $profile
 * @property integer $create_time
 * @property integer $last_login
 *
 * The followings are the available model relations:
 * @property LinkUserGroupUser[] $linkUserGroupUsers
 * @property UserActionLog[] $userActionLogs
 */
class BaseUser extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseUser the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('create_time, last_login', 'numerical', 'integerOnly'=>true),
			array('name, login, hashed_password, email', 'length', 'max'=>128),
			array('profile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, login, hashed_password, email, profile, create_time, last_login', 'safe', 'on'=>'search'),
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
			'linkUserGroupUsers' => array(self::HAS_MANY, 'LinkUserGroupUser', 'user_id'),
			'userActionLogs' => array(self::HAS_MANY, 'UserActionLog', 'user_id'),
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
			'login' => 'Login',
			'hashed_password' => 'Hashed Password',
			'email' => 'Email',
			'profile' => 'Profile',
			'create_time' => 'Create Time',
			'last_login' => 'Last Login',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('hashed_password',$this->hashed_password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile',$this->profile,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('last_login',$this->last_login);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}