<?php
/**
 * Class User
 * @method User active()
 * @property LinkUserGroupUser[] $linkUserGroupUsers
 * @property UserActionLog[] $userActionLogs
 */
class User extends BaseUser
{
	// пол пользователя
	const GENDER_MALE = 'male';
	const GENDER_FEMALE = 'female';

	public $password;

	/**
	 * User
	 * @param string $className
	 * @return User
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('email, login, name, hashed_password', 'required'),
			array('login', 'unique'),
			array('email', 'email'),
			array('create_time, last_login', 'numerical', 'integerOnly'=>true),
			array('name, login, hashed_password, email', 'length', 'max'=>128),
			array('profile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, login, hashed_password, email, profile, create_time, last_login, password', 'safe'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'linkUserGroupUsers' => array(self::HAS_MANY, 'LinkUserGroupUser', 'user_id'),
			'userActionLogs' => array(self::HAS_MANY, 'UserActionLog', 'user_id'),
		);
	}


	public function beforeValidate()
	{
		if (!empty($this->password)) {
			$this->hashed_password = self::hashPassword($this->password);
		}
		return parent::beforeValidate();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Имя',
			'login' => 'Логин',
			'password' => 'Пароль',
			'hashed_password' => 'Пароль2',
			'email' => 'Email',
			'profile' => 'Профиль',
		);
	}


	public function scopes()
	{
		$tableAlias = $this->getTableAlias(false, false);
		return array(
			'active' => array(),
		);
	}


	/**
	 * Checks if the given password is correct.
	 * @param string $password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->hashed_password == self::hashPassword($password);
	}

	/**
	 * Generates the password hash.
	 * @param string $password
	 * @return string hash
	 */
	public static function hashPassword($password)
	{
		return md5($password);
	}



	/**
	 * Регистрация пользователя из социальной сети
	 * @param $socialAttributes
	 * @param int $activated
	 * @return bool
	 * @throws CException
	 */
	public function registerUserFromSocNetwork($socialAttributes, $activated = 0)
	{
		if (empty($socialAttributes['email']))
			throw new CException('Не передан email');

		$this->email = $socialAttributes['email'];
		$this->name = self::createName($socialAttributes['name']);

		$this->password = $this->generatePassword();
		$this->hashed_password = self::hashPassword($this->password);

		$this->_setFieldsOnRegistration($activated);

		if (!$this->save()) {
			throw new CException('Регистрация не произошла');
		};

		return true;
	}

	public static function generatePassword()
	{
		$alphabet = array(
			array('b','c','d','f','g','h','g','k','l','m','n','p','q','r','s','t','v','w','x','z',
				'B','C','D','F','G','H','G','K','L','M','N','P','Q','R','S','T','V','W','X','Z'),
			array('a','e','i','o','u','y','A','E','I','O','U','Y'),
		);

		$new_password = '';
		for($i = 0; $i < 9 ;$i++)
		{
			$j = $i%2;
			$min_value = 0;
			$max_value = count($alphabet[$j]) - 1;
			$key = rand($min_value, $max_value);
			$new_password .= $alphabet[$j][$key];
		}
		return $new_password;
	}

	public static function createName($name)
	{
		return substr($name, 0, 255);
	}


	/**
	 * Сет дефолтовых полей при регистрации пользователя
	 * @param int $activated
	 */
	protected function _setFieldsOnRegistration($activated = 0)
	{

	}


	public static function createLogin($login)
	{
		$login = trim(preg_replace ("/[^a-zA-Z0-9\-]/","",$login), "\-");

		// проверяем занят ли логин
		$existsLogin = User::model()->countByAttributes(array('login'=>$login));
		if ($existsLogin == 0)
			return $login;

		// такой логин уже занят, поэтому проверяем добавляем икримент к логину
		$countUsersWithSameLogin = User::model()->count('login LIKE (:login)', array('login' => $login . '%'));
		$countNumber = $countUsersWithSameLogin++;

		return $login . $countNumber;
	}


	/**
	 * Входит ли пользователь в группу
	 * @param $groupId
	 * @return bool
	 */
	public function isInGroup($groupId)
	{
		foreach ($this->linkUserGroupUsers as $linkGroup) {

			if ($linkGroup->user_group_id == $groupId) {

				return true;
			}
		}

		return false;
	}


	/**
	 * Является ли пользователь администратором группы
	 * @param $groupId
	 * @return bool
	 */
	public function isAdminInGroup($groupId)
	{
		foreach ($this->linkUserGroupUsers as $linkGroup) {
			if ($linkGroup->user_group_id == $groupId) {
				if ($linkGroup->group_admin == 1)
					return true;
				return false;
			}
		}

		return false;
	}


	public function isGroupAdmin()
	{
		foreach ($this->linkUserGroupUsers as $linkGroup) {
				if ($linkGroup->group_admin == 1)
					return true;
				return false;
		}

		return false;
	}


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

		if (!Yii::app()->getUser()->isAdmin()) {
			$groups  = Yii::app()->getUser()->getAvailableGroups();
			$criteria->with['linkUserGroupUsers'] = array(
				'joinType' => 'inner join'
			);
			$criteria->together = true;
			$criteria->addInCondition('linkUserGroupUsers.user_group_id', array_keys($groups));
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
