<?php

class CanvasPrint10Controller extends ApiBaseController
{

	protected $version = '1.0';
	protected $_sigSalt = 'ps_miodj90j9043904k[p45g,g,k54h.l4=-3lk4j5mh';


	public function filters()
	{
		$filters = parent::filters();
		$filters[] = array(
			'FilterCheckSig + ApiGetOrder + ApiUpdateOrder + ApiUpdateOrderStatus',
			'sigSalt'=> $this->_sigSalt,
			'params' => $this->jsonRPC->getRequestParams(),
			'methodName' => $this->jsonRPC->getRequestMethodName(),
		);

		return $filters;
	}


	/**
	 * Возвращает информацию о заказе по его идентификатору на стороне photosight.ru.
	 * @throws ApiException
	 * {"method":"GetOrder","params":[{"ID":215,"sig":"0a9f5e84f886a4e0d31cc4f06630bd61","userSID":"shop1"}],"id":2}
	 */
	public function actionApiGetOrder()
	{
		$params = $this->jsonRPC->getRequestParams();
		if (empty($params['ID']) || $params['ID'] < 1) {
			throw new ApiException('Идентификатор заказа не найден', CanvasPrintApiException::$errorCodes['BadRequest']);
		}

		$orderId = $params['ID'];

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

		if (empty($order)) {
			throw new CanvasPrintApiException('Заказ не найден', CanvasPrintApiException::$errorCodes['NotFound']);
		}

		$arResult = $order->returnOrderAttributesForApi();

		$this->render('/api/index', array('response' => $arResult));
	}


	/**
	 * Обновляет информацию о заказе. Все поля в запросе не обязательны
	 */
	public function actionApiUpdateOrder()
    {
	    $params = $this->jsonRPC->getRequestParams();
	    if (empty($params['ID']) || $params['ID'] < 1) {
		    throw new ApiException('Идентификатор заказа не найден', CanvasPrintApiException::$errorCodes['BadRequest']);
	    }

	    $orderId = $params['ID'];

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

	    if (empty($order)) {
		    throw new CanvasPrintApiException('Заказ не найден', CanvasPrintApiException::$errorCodes['NotFound']);
	    }

	    $oldStatus = $order->status;

	    // статус заказа
		if (!empty($params['status'])) {

			if (!CanvasPrintOrder::isApiStatusStringValid($params['status'])) {
				throw new CanvasPrintApiException('Статус передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			}
			$order->status = $params['status'];
		}

	    // Тип оформления торца
	    if (!empty($params['canvasBorderType'])) {
		    if (!in_array($params['canvasBorderType'], array_keys( Yii::app()->params['canvasPrint']['canvasBorderType'] ))) {
			    throw new CanvasPrintApiException('Тип оформления торца передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }
		    $order->canvas_border_type = $params['canvasBorderType'];
	    }


	    if (!empty($params['canvasWidth']) && !empty($params['canvasHeight'])) {

		    if ( intval($params['canvasWidth']) != $params['canvasWidth'] || intval($params['canvasHeight']) != $params['canvasHeight'] ) {
			    throw new CanvasPrintApiException('Размеры холста переданы не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }

		    $order->canvas_width = $params['canvasWidth'];
		    $order->canvas_height = $params['canvasHeight'];
	    }

		// имя заказчика
	    if (!empty($params['name'])) {
		   $order->name = $params['name'];
	    }


		// email заказчика
	    if (!empty($params['email'])) {
		    $order->email = $params['email'];
	    }

		// телефон заказчика
	    if (!empty($params['phone'])) {
		    $order->email = $params['phone'];
	    }


	    // является ли заказчик юридическим лицом
		if (!empty($params['isCompany'])) {
			if (!in_array($params['isCompany'], array('no','yes'))) {
			  throw new CanvasPrintApiException('Тип клиента передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			}
			$order->is_company = $params['isCompany'] == 'yes' ? 1 : 0;

			if ($params['isCompany'] == 'yes') {

				// название юридического лица
				if (!empty($params['companyName'])) {
					$order->company_name = $params['companyName'];
				}


				// ИНН юридического лица
				if (!empty($params['companyInn'])) {
					if ( intval($params['companyInn']) != $params['companyInn'] ) {
						throw new CanvasPrintApiException('ИНН юридического лица передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
					}
					$order->company_inn = $params['companyInn'];
				}

				// КПП юридического лица
				if (!empty($params['companyKpp'])) {
					if ( intval($params['companyKpp']) != $params['companyKpp'] ) {
						throw new CanvasPrintApiException('КПП юридического лица передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
					}
					$order->company_inn = $params['companyInn'];
				}

				// юридический адрес юридического лица
				if (!empty($params['companyAddress'])) {
					$order->company_address = $params['companyAddress'];
				}

				//  фактический/почтовый адрес юридического лица
				if (!empty($params['companyPostAddress'])) {
					$order->company_post_address = $params['companyPostAddress'];
				}

				// тип доставки. Доставка (delivery) или самовывоз (self)
				if (!empty($params['deliveryType'])) {
					if (!in_array($params['deliveryType'], array('delivery','self'))) {
						throw new CanvasPrintApiException('КПП юридического лица передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
					}
				}
			}
		}


	    //  фактический/почтовый адрес юридического лица
	    if (!empty($params['deliveryCity'])) {
		    $order->delivery_city = $params['deliveryCity'];
	    }

	    //  deliveryAddress – адрес доставки
	    if (!empty($params['deliveryCity'])) {
		    $order->delivery_address = $params['deliveryAddress'];
	    }

	    // прислать счёт по электронной почте изготовления т.п.
	    if (!empty($params['sendInvoice'])) {
		    if (!in_array($params['sendInvoice'], array('no','yes'))) {
			    throw new CanvasPrintApiException('прислать счёт по электронной почте передано не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }
		    $order->send_invoice = $params['sendInvoice'] == 'yes' ? 1 : 0;
	    }

	    // способ оплаты
	    if (!empty($params['paymentType'])) {
		    if (!in_array($params['paymentType'], array('cash','invoice'))) {
			    throw new CanvasPrintApiException('прислать счёт по электронной почте передано не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }
		    $order->payment_type = $params['paymentType'];
	    }


	    // статус оплаты
	    if (!empty($params['paymentStatus'])) {
		    if (!CanvasPrintOrder::isApiPaymentStatusValid($params['paymentStatus'])) {
			    throw new CanvasPrintApiException('статус оплаты передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }
		    $order->payment_status = $params['paymentType'];
	    }


	    // стоимость заказа
	    if (!empty($params['price'])) {

		    if (!is_array($params['price'])) {
			    throw new CanvasPrintApiException('Стоисмость заказа передана не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		    }

		    if (!empty($params['price']['canvas'])) {
			    if (doubleval($params['price']['canvas']) != $params['price']['canvas']) {
				    throw new CanvasPrintApiException('Стоисмость заказа передана не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			    }
			    $order->canvas_price = $params['price']['canvas'];
		    }

		    if (!empty($params['price']['discount'])) {
			    if (doubleval($params['price']['discount']) != $params['price']['discount']) {
				    throw new CanvasPrintApiException('Стоисмость заказа передана не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			    }
			    $order->canvas_price = $params['price']['discount'];
		    }

		    if (!empty($params['price']['delivery'])) {
			    if (doubleval($params['price']['delivery']) != $params['price']['delivery']) {
				    throw new CanvasPrintApiException('Стоисмость заказа передана не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			    }
			    $order->canvas_price = $params['price']['delivery'];
		    }

		    if (!empty($params['price']['more'])) {
			    if (doubleval($params['price']['more']) != $params['price']['more']) {
				    throw new CanvasPrintApiException('Стоисмость заказа передана не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
			    }
			    $order->canvas_price = $params['price']['more'];
		    }

			$order->user_price_payable = $params['price']['canvas'] + $params['price']['delivery'] + $params['price']['more'] - $params['price']['delivery'];
	    }


	    // комментарий партнера
	    if (!empty($params['partnerComment'])) {
		    $order->partner_comment = $params['partnerComment'];
	    }


	    // сохранение заказа
	    if (!$order->save()) {
		    $errors = '';
		    foreach ($order->errors as $fieldErrors) {
			    foreach ($fieldErrors as $item) {
				    $errors .= $item."\n";
			    }
		    }
		    throw new CanvasPrintApiException('Заказ не сохранен Ошибки: '.$errors, CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
	    }

	    // если смена статусов передана не валидно
	    if ($oldStatus != $order->status && !CanvasPrintOrder::isApiStatusSequenceValid($oldStatus, $order->status)) {
		    $mailEvent = new MailEvent();
		    $mailEvent->actionCanvasPrintApiPartnerError($order, $this->jsonRPC->getResponse());
	    }



	    $this->render('/api/index', array('response' => array()));
    }




	public function actionApiUpdateOrderStatus()
	{
		$params = $this->jsonRPC->getRequestParams();

		if (empty($params['ID']) || $params['ID'] < 1) {
			throw new ApiException('Идентификатор заказа не найден', CanvasPrintApiException::$errorCodes['BadRequest']);
		}

		$orderId = $params['ID'];

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

		if (empty($order)) {
			throw new CanvasPrintApiException('Заказ не найден', CanvasPrintApiException::$errorCodes['NotFound']);
		}

		$oldStatus = $order->status;

		if (empty($params['status'])) {
			throw new CanvasPrintApiException('Статус не передан', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		}


		if (!CanvasPrintOrder::isApiStatusStringValid($params['status'])) {
			throw new CanvasPrintApiException('Статус передан не верно', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		}
		$order->status = $params['status'];


		// комментарий партнера
		if (!empty($params['partnerComment'])) {
			$order->partner_comment = $params['partnerComment'];
		}

		// сохранение заказа
		if (!$order->save()) {
			$errors = '';
			foreach ($order->errors as $fieldErrors) {
				foreach ($fieldErrors as $item) {
					$errors .= $item."\n";
				}
			}
			throw new CanvasPrintApiException('Заказ не сохранен', CanvasPrintApiException::$errorCodes['UnsupportedMediaType']);
		}

		// если смена статусов передана не валидно
		if ($oldStatus != $order->status && !CanvasPrintOrder::isApiStatusSequenceValid($oldStatus, $order->status)) {
			$mailEvent = new MailEvent();
			$mailEvent->actionCanvasPrintApiPartnerError($order, $this->jsonRPC->getResponse());
		}

		$this->render('/api/index', array('response' => array()));
	}

}