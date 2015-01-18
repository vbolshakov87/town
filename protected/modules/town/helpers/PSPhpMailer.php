<?php
/**
 * Отправка писем по протоколу SMTP
 */

Yii::import ( 'application.vendors.phpmailer.class_phpmailer', true );

class PSPhpMailer extends PHPMailer
{

	public function Send() {

		// отправляем письмо на почту разработчика на девелоперском сайте
		if (_ENVIRONMENT === 'development') {

			// если не определен разработчик, то не отправляем письмо
			if (!defined('DEV_PS_USERHOST'))
				return true;

			// сбрасываем список получателей
			$this->ClearAllRecipients();

			$this->AddAddress(DEV_PS_USERHOST.'@webmg.ru');
		}

		return parent::Send();
	}


	public function mailConnect()
	{
		// настройки соединения при отправке писем по smtp
		if (Yii::app()->params['mailerProvider'] == 'smtp') {
			$this->IsSMTP();
			$this->SMTPAuth = Yii::app()->params['mail']['SMTPSettings']['SmtpAuth'];
			$this->Username = Yii::app()->params['mail']['SMTPSettings']['Login'];
			$this->Password = Yii::app()->params['mail']['SMTPSettings']['Password'];
			$this->Port = Yii::app()->params['mail']['SMTPSettings']['Port'];
			$this->Host = Yii::app()->params['mail']['SMTPSettings']['Host'];
		}

		$this->From = Yii::app()->params['mail']['MailFrom']['Email'];
		$this->FromName = Yii::app()->params['mail']['MailFrom']['Name'];

		$this->IsHTML(true); // send as HTML
		$this->CharSet  = 'utf-8';
		$this->DKIM_selector = '';
	}

}
