<?php
/**
 * Класс с исправленными ошибками api facebook
 */
require_once "facebook.php";
class ApiFacebook extends Facebook
{
	public function __construct($config)
	{
		// добавил недостающие данные
		self::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;

		// убрал старт сессии из конструкторора класса. Пришлось скопипастить весь конструктор из BaseFacebook
		$this->setAppId($config['appId']);
		$this->setAppSecret($config['secret']);
		if (isset($config['fileUpload'])) {
			$this->setFileUploadSupport($config['fileUpload']);
		}
		if (isset($config['trustForwarded']) && $config['trustForwarded']) {
			$this->trustForwarded = true;
		}
		$state = $this->getPersistentData('state');
		if (!empty($state)) {
			$this->state = $state;
		}

		if (!empty($config['sharedSession'])) {
			$this->initSharedSession();
		}
	}


	protected function clearAllPersistentData() {
		return;
	}
}