<?php
/**
 * Авторизация пользователя через аккаунт в социальной сети
 * @method FrontController getController()
 * @property User $member
 * @property LoginForm $_loginForm
 * @property SocialLoginForm $_socialLoginForm
 */
class SocNetworkLoginAction extends CAction
{
	protected $_socialAttributes;
	protected $_loginForm;
	protected $_socialLoginForm;
	protected $_site; // с какого сайта пришел пользователь. Со старого или с нового
	protected $_service; // с какого сайта пришел пользователь. Со старого или с нового


	public function init()
	{
		$this->getController()->disableLogs();
		$this->getController()->layout = 'socialPopUp';
		$this->_site = Yii::app()->getRequest()->getParam('from', 'old');
		$this->_service = Yii::app()->getRequest()->getParam('service');

	}

	public function run()
	{
		try {

			$this->init();

			if (empty($this->_service) || Yii::app()->getUser()->isGuest === false) {
				$this->_closeWindow();
			}

			// получаем данные пользователя из сессиии
			$this->_socialAttributes = $this->_getUserDataFromSocialNetwork();

			// привязка к аккаунту
			$this->_loginForm = new LoginForm();

			// создание нового аккаунта
			$this->_socialLoginForm = new SocialLoginForm();
			if (!empty($this->_socialAttributes['email']) && !empty($this->_socialAttributes['trustedByEmail'])) {
				$this->_socialLoginForm->email = $this->_socialAttributes['email'];
			}



			// попытка авторизации по полученным данным
			if (
				$this->_authoriseBySocialId() // если пользователь уже авторизовывался через социалку
				|| $this->_authoriseByEmail() // если пользователь уже зарегистрирован на сайте с тем же email что и в социалке
				|| $this->_authoriseByForm() // если пользователь авторизовался через форму
			) {
				// привязываем аккаунт пользователя
				Yii::app()->getUser()->getUser()->bindSocialAccountToMember($this->_socialAttributes);

				$this->_closeWindow();
			} elseif(
				$this->_regAndAuthByEmail() // если пользователь зарегистрирвоан по email от доверенной социальной сети
				|| $this->_regByForm() // если пользователь зарегистрировался через форму
			) {
				$this->_closeWindow();
			}

			// вывод страницы c формой авторизации
			else {
				// форма связки аккаунтов
				$this->getController()->render('socialConnectForm', array(
					'attributes'=>$this->_socialAttributes,
					'loginForm' => $this->_loginForm,
					'socialLoginForm' => $this->_socialLoginForm,
					'notActivatedSocialMember' => $this->_getSocialUserNotActivated() // если пользователь уже регистрировался, но не подтвердил свой аккаунт
				));
			}

		}
		catch (Exception $e) {
			if ( _ENVIRONMENT == 'development') {
				echo "<pre>";
				print_R($e);
				echo "</pre>";
				exit;
			}
			$this->_closeWindow();
		}
	}


	/**
	 * Получение данных из социальной сети
	 * @return array
	 */
	public function _getUserDataFromSocialNetwork()
	{
		$socialAttributeSessionKey = 'socialAttributes_'.$this->_service;
		$socialAttributes = Yii::app()->getUser()->readFromSession($socialAttributeSessionKey);

		// если пользователь не авторизован в социаке
		if (empty($socialAttributes)) {

			$authIdentity = Yii::app()->eauth->getIdentity($this->_service);
			if ($authIdentity->authenticate()) {

				$socialAttributes = $authIdentity->getAttributes();
				if (empty($this->_socialAttributes))
					new CException('Ответ из социальной сети не получен');

				Yii::app()->getUser()->writeIntoSession($socialAttributeSessionKey, $socialAttributes);
			}
		}

		return $socialAttributes;
	}


	protected function _closeWindow()
	{
		Yii::app()->getRequest()->redirect(Yii::app()->createAbsoluteUrl('auth/popUpRedirect'));
		Yii::app()->end();
	}


	/**
	 * Авторизация пользователя
	 * @return bool
	 */
	protected function _authoriseByForm()
	{
		if (!empty($_POST['LoginForm'])) {
			$this->_loginForm->attributes = $_POST['LoginForm'];
			if ($this->_loginForm->validate() && $this->_loginForm->login()) {
				// очищаем привязку между пользователем и социалкой
				UserSocialNetwork::model()->deleteAllByAttributes(array('social_network' => $this->_socialAttributes['socialNetwork'], 'social_network_id' => $this->_socialAttributes['id']));
				return true;
			}
		}

		return false;
	}

	/**
	 * Если из социалки передан email - проверяем можно ли авторизовать пользователя
	 */
	protected function _authoriseByEmail()
	{
		if (!empty($this->_socialAttributes['email']) && !empty($this->_socialAttributes['trustedByEmail'])) {

			$emailIdentity = new UserIdentityByEmail($this->_socialAttributes['email']);
			if ($emailIdentity->authenticate()) {
				$duration = 3600*24*365;
				return Yii::app()->getUser()->login($emailIdentity, $duration);
			}
		}

		return false;
	}


	/**
	 * Регистрация и авторизация по email
	 * @return bool
	 */
	protected function _regAndAuthByEmail()
	{
		if (empty($_POST['SocialLoginForm']) || empty($this->_socialAttributes['email']) || empty($this->_socialAttributes['trustedByEmail']))
			return false;

		$user = new User();

		// регистрация пользователя
		$user->registerUserFromSocNetwork($this->_socialAttributes, 1);

		// flash message
		Yii::app()->getUser()->writeIntoSession('socRegSuccess',  Yii::app()->params['registrationByEmail']['popupMessage']);

		// отправка письма пользователю
		//$mailEvent = new MailEvent();
		//$mailEvent->actionMemberRegistrationActivated($user);

		if  ($this->_authoriseByEmail()) {
			// привязываем аккаунт пользователя
			Yii::app()->getUser()->getUser()->bindSocialAccountToMember($this->_socialAttributes);

			return true;
		}

		return false;
	}


	/**
	 * Авторизация пользователя
	 * @return bool
	 */
	protected function _regByForm()
	{
		if (!empty($_POST['SocialLoginForm'])) {
			$this->_socialLoginForm->attributes = $_POST['SocialLoginForm'];
			if ($this->_socialLoginForm->validate() && $this->_socialLoginForm->isUniqueEmail()) {

				$this->_socialAttributes['email'] = $this->_socialLoginForm->email;
				$user = new User();
				// регистрация пользователя
				$user->registerUserFromSocNetwork($this->_socialAttributes);

				// очищаем привязку между пользователем и социалкой
				UserSocialNetwork::model()->deleteAllByAttributes(array('social_network' => $this->_socialAttributes['socialNetwork'], 'social_network_id' => $this->_socialAttributes['id']));

				// привязываем аккаунт пользователя
				$user->bindSocialAccountToMember($this->_socialAttributes);

				Yii::app()->getUser()->writeIntoSession('socRegSuccess',  Yii::app()->params['registration']['popupMessage']);
				// отправка письма пользователю
				//$mailEvent = new MailEvent();
				//$mailEvent->actionMemberRegistration($user);
				return true;
			}
		}

		return false;
	}


	/**
	 * Авторизация по id пользователя в социалке
	 * @return bool
	 */
	protected function _authoriseBySocialId()
	{
		/** @var $userSocialAccount UserSocialNetwork */
		$userSocialAccount = UserSocialNetwork::model()->findByAttributes(array(
			'social_network' => $this->_socialAttributes['socialNetwork'],
			'social_network_id' => $this->_socialAttributes['id'],
		));

		if (!empty($userSocialAccount)) {
			$IdIdentity = new UserIdentityById($userSocialAccount->user_id);
			if ($IdIdentity->authenticate()) {
				$duration = 3600*24*365;
				return Yii::app()->getUser()->login($IdIdentity, $duration);
			}
			else {
				/*
				// если пользователь есть в списке и он не активен - то закрываем окно авторизации
				$blockedMemberCount = User::model()->countByAttributes(array('id'=>$userSocialAccount->member_id), 't.is_blocked=1 OR t.is_removed=1');
				if ($blockedMemberCount > 0) {
					$this->_closeWindow();
				}
				*/
			}
		}

		return false;
	}


	protected function _getSocialUserNotActivated()
	{
		/** @var $memberSocialAccount UserSocialNetwork */
		$criteria = new CDbCriteria(array(
			'with' => array(
				'user' => array(
					'joinType' => 'inner join',
					'select' => false,
				),
			),
			'together' => true,
			'condition' => 't.social_network = :social_network AND t.social_network_id = :social_network_id',
			'params' => array(
				':social_network' => $this->_socialAttributes['socialNetwork'],
				':social_network_id' => $this->_socialAttributes['id'],
			)
		));

		return UserSocialNetwork::model()->find($criteria);
	}



}