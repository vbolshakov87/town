<?php
class ClientApiException extends Exception {}


/**
 * клиентское Api для интеграции с партнерами photosight.ru
 * @property BaseClientApi $_clientApi
 * @method ApiJsonRpcClient GetVersion()
 * @method ApiJsonRpcClient PingPong(array $params)
 * @method ApiJsonRpcClient PingPongSig(array $params)
 * @method ApiJsonRpcClient PingPongAuth(array $params)
 * @method ApiJsonRpcClient GetUserSID()
 * @method ApiJsonRpcClient PostOrder($orderId)
 * @method ApiJsonRpcClient UpdateOrder($orderId)
 * @method ApiJsonRpcClient UpdateOrderStatus($orderId)
 * @method ApiJsonRpcClient GetOrder($orderId)
 */
class ApiJsonRpcClient
{
	protected $_clientApi; // версия api для интеграции


	public function setServer($config)
	{
		if (empty($config['serverUrl']) || empty($config['sigSalt']) || empty($config['clientApiClass']))
			throw new CException('Конфиг сервера не передан');

		$this->_clientApi = new $config['clientApiClass'];
		$this->_clientApi->setServerUrl($config['serverUrl']);
		$this->_clientApi->setSigSalt($config['sigSalt']);
		$this->_clientApi->setApplicationId($config['applicationId']);
	}


	public function __call($name, $parameters)
	{
		if (empty($this->_clientApi))
			throw new CException('Конфиг сервера не передан');

		return call_user_func_array(array($this->_clientApi, 'Api'.$name), $parameters);
	}
}