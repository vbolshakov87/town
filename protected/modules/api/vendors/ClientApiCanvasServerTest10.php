<?php
/**
 * Тест работы серверного приложения фотосайта
 */
class ClientApiCanvasServerTest10 extends ClientApiCanvasPrint10
{

	public function __construct()
	{
		$this->_debug = true;
	}


	public function ApiUpdateOrder($orderId)
	{
		$orderCriteria = new CDbCriteria(array(
			'condition' => 't.id = :orderId',
			'limit' => 1,
			'params' => array(
				':orderId' => $orderId,
			),
		));
		$orderCriteria->addInCondition('t.status', array(CanvasPrintOrder::STATUS_NEW, CanvasPrintOrder::STATUS_VERIFIED ));

		/** @var CanvasPrintOrder $order */
		$order = CanvasPrintOrder::model()->find($orderCriteria);

		if (!empty($order)) {
			$params = $order->returnOrderAttributesForApi();
			$params['sig'] = $this->_getSig('UpdateOrder', $params);
			return $this->_sendApiRequest('UpdateOrder', $params);
		}

		throw new ClientApiException('Заказ не найден', 404);
	}



	public function ApiUpdateOrderStatus($orderId)
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
			$params = array(
				'ID' => $order->id,
				'status' => CanvasPrintOrder::STATUS_PRINTED
			);
			$params['sig'] = $this->_getSig('UpdateOrderStatus', $params);

			return $this->_sendApiRequest('UpdateOrderStatus', $params);
		}

		throw new ClientApiException('Заказ не найден', 404);
	}
}