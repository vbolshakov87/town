<?php
/**
 * Базовый класс для интеграции с парртнерами
 */
class BaseClientApi
{
	protected $_serverUrl;// Фотосайт  обращается к API по адресу:
	protected $_sigSalt; // фотосайт использует эту соль в запросах
	protected $_applicationId; // идентификатор партнера
	protected $_debug; // Выводить дебагер


	public function __construct()
	{
		$this->_debug = Yii::app()->params['apiClient']['debug'];
	}


	/**
	 * @param mixed $serverUrl
	 */
	public function setServerUrl($serverUrl)
	{
		$this->_serverUrl = $serverUrl;
	}


	/**
	 * @param mixed $sigSalt
	 */
	public function setSigSalt($sigSalt)
	{
		$this->_sigSalt = $sigSalt;
	}



	/**
	 * @param mixed $applicationId
	 */
	public function setApplicationId($applicationId)
	{
		$this->_applicationId = $applicationId;
	}


	protected function _getSig($method, $params )
	{
		return md5($method . TextModifier::arr2str($params) . $this->_sigSalt);
	}

}