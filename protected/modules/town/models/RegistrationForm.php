<?php
/**
 * Модель регистрации на сайте
 */
class RegistrationForm extends CFormModel
{
	public $name;
	public $email;
	public $password;

	public function rules()
	{
		return array(
			// username and password are required
			array('name, email, password', 'required'),
			array('name', 'length', 'max'=>32),
			array('email', 'length', 'max'=>64),
			array('email', 'email'),
			array('password', 'length', 'min'=>6, 'max' => 32),
			array('email', 'validateUniqueUser'),
		);
	}


	public function validateUniqueUser($attribute,$params)
	{
		$userCount = User::model()->countByAttributes(array('email' => $this->email));
		if($userCount > 0) {
			$this->addError('email','This email already exists.');
			return false;
		}

		return true;
	}


	public function attributeLabels()
	{
		return array(
			'name'=>'Full Name',
		);
	}


	public function registerUser()
	{
		$user = new User();
		$user->name = $this->name;
		$user->email = $this->email;
		$user->hashed_password = User::hashPassword($this->password);
		if (!$user->save()) {
			$errors = '';
			foreach ($user->errors as $fieldErrors) {
				foreach ($fieldErrors as $item) {
					$errors .= $item.'<br />';
				}
			}
			Yii::app()->getUser()->setFlash('registrationError', $errors);
			return false;
		}

		return true;
	}
}