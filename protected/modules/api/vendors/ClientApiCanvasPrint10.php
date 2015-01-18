<?php

/**
 * клиентское Api для интеграции с партнерами photosight.ru для печати на холсте
 */
class ClientApiCanvasPrint10 extends BaseClientApi
{
	public function ApiGetVersion ()
	{
		return $this->_sendApiRequest('GetVersion');
	}

	public function ApiPingPong ($params)
	{
		return $this->_sendApiRequest('PingPong', $params);
	}



	public function ApiPingPongSig ($params)
	{
		$params['sig'] = $this->_getSig('PingPongSig', $params);
		return $this->_sendApiRequest('PingPongSig', $params, 1381920710);
	}

	public function ApiPingPongAuth ($params)
	{
		$params['sig'] = $this->_getSig('PingPongSig', $params);
		return $this->_sendApiRequest('PingPongSig', $params);
	}


	/**
	 * Отправка информации о заказе.
	 * @param $orderId
	 * @return mixed
	 * @throws ClientApiException
	 */
	public function ApiPostOrder($orderId)
	{
		$orderCriteria = new CDbCriteria(array(
			'condition' => 't.id = :orderId AND t.status != :statusDraft',
			'limit' => 1,
			'params' => array(
				':orderId' => $orderId,
				':statusDraft' => CanvasPrintOrder::STATUS_DRAFT,
			),
		));

		/** @var CanvasPrintOrder $order */
		$order = CanvasPrintOrder::model()->find($orderCriteria);



		if (!empty($order)) {
			$params = $order->returnOrderAttributesForApiClient();
			$params['sig'] = $this->_getSig('PostOrder', $params);

			return $this->_sendApiRequest('PostOrder', $params);
		}

		throw new ClientApiException('Заказ не найден', 404);
	}


	/**
	 * Обновляет информацию о заказе. Все поля в запросе не обязательны. Обновление заказа возможно только до того момента, пока он не достиг статуса печатается (printing).
	 * @param $orderId
	 * @return mixed
	 * @throws ClientApiException
	 */
	public function ApiUpdateOrder($orderId)
	{
		$orderCriteria = new CDbCriteria(array(
			'condition' => 't.id = :orderId',
			'limit' => 1,
			'params' => array(
				':orderId' => $orderId,
			),
		));
		$orderCriteria->addInCondition('t.status', CanvasPrintOrder::statusListOnPartnerCanUpdate());

		/** @var CanvasPrintOrder $order */
		$order = CanvasPrintOrder::model()->find($orderCriteria);

		if (!empty($order)) {
			$params = $order->returnOrderAttributesForApiClient();

			$params['sig'] = $this->_getSig('UpdateOrder', $params);

			return $this->_sendApiRequest('UpdateOrder', $params);
		}

		throw new ClientApiException('Заказ не найден', 404);
	}


	public function ApiGetOrder($orderId)
	{
		$params = array('ID' => $orderId);
		$params['sig'] = $this->_getSig('GetOrder', $params);

		return $this->_sendApiRequest('GetOrder', $params);
	}


	protected function _sendApiRequest($method, $params = array(), $id=1)
	{
		$request = array(
			'method' => $method,
			'params' => array($params),
			'id' => $id,
		);

		$requestJson = json_encode($request);

		if ($this->_debug) {
			print "<pre>Request: <br />";
			var_dump($request);
			print '<br />';
			print $requestJson;
			print '<br /><hr />';
			print "</pre>";
		}

		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $this->_serverUrl);
		curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POSTFIELDS, $requestJson);
		$data = curl_exec ($c);

		// Проверяем наличие ошибки
		if(curl_errno($c)) {
			throw new ClientApiException('Ошибка curl: ' . curl_error($c), 500);
		}

		curl_close ($c);


		if ($this->_debug)
		{
			print "<pre>Response: <br />";
			var_dump(json_decode($data, true) );
			print '<br />';
			print $data;
			print '<br /><hr />';
			print "</pre>";
		}

		$apiLog = new ApiLog();
		$apiLog->ctime = time();
		$apiLog->api_type = 'client';
		$apiLog->request = $requestJson;
		$apiLog->application_id = $this->_applicationId;
		$apiLog->response = $data;
		$apiLog->save();


		return json_decode($data, true);
	}

}