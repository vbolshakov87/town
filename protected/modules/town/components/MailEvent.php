<?php
/**
 * Отправка писем пользователю
 */
class MailEvent
{

	public $viewDirectory = 'mailBody';

	public function init()
	{

	}

	/**
	 * Подключению view файла
	 * @param $_viewFile_
	 * @param null $_data_
	 * @return string
	 */
	protected function _renderFile($_viewFile_,$_data_=null)
	{
		$_viewFile_ = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->viewDirectory . DIRECTORY_SEPARATOR . $_viewFile_ . 'UnderWaterStatWidget.php';

		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');

		ob_start();
		ob_implicit_flush(false);
		require($_viewFile_);
		return ob_get_clean();
	}


	/**
	 * Тестовый пример работы с отправкой писем
	 * @param StdClass $class
	 * @return bool
	 */
	public function actionExample(StdClass $class)
	{
		$mailer = new PSPhpMailer();
		$mailer->mailConnect();
		$mailer->AddAddress($class->email, $class->name);
		$mailer->AddBCC('bcct@example.com');
		$mailer->Subject = 'Test Subject';
		$mailer->Body = $this->_renderFile('test', array('class'=>$class));

		EmailSentLog::addToLog($class->id, 'testMailSent');

		return $mailer->Send();
	}


	/**
	 * Регистрация на сайте
	 * @param User $user
	 * @return bool
	 */
	public function sendUserRegistration(User $user)
	{
		$mailer = new PSPhpMailer();
		$mailer->mailConnect();
		//$mailer->AddBCC('ashatrov@webmg.ru');
		//$mailer->AddBCC('vbolshakov@photosight.ru');
		$mailer->AddAddress($user->email, $user->name);
		$mailer->Subject = "new registration";
		$mailer->Body = $this->_renderFile('userRegistration', array('user'=>$user));
		return $mailer->Send();
	}
}
