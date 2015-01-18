<?php
/**
 * Exception для api обмена заказами печати на холсте
 *
 */
class CanvasPrintApiException extends ApiException
{

    public static $errorCodes = array(
        /* Клиентские ошибки */
        'BadRequest' => 400, // «Плохой, неверный запрос» - Неправильная контрольная сумма запроса (подпись, SIG), запрос не в формате JSON-RPC 1.0, пустой запрос, запрос с синтаксической ошибкой.
        'Unauthorized' => 401, // «Неавторизован» - попытка выполнить действие от имени неавторизованного пользователя токен (номер сесии) пользователя не валиден.
        'Forbidden' => 403, // «Запрещено» - Доступ запрещён, действие запрещено, передавать такие параметры запрещено, не передавать параметры запрещено и т.п.
        'NotFound' => 404, // «Не найдено» - Запись не найдена; фотография не найдена; заказ не найден. Клиент запрашивает информацию, которую сервер не может найти.
        'NotAcceptable' => 406, // «Неприемлемо» - Не передан обязательный параметр;
        'UnsupportedMediaType' => 415, // «Неверный параметр» - должен быть числовой, а передаётся строка; массив вместо строки и т.п.

        /* Серверные ошибки */
        'InternalServerError' => 500, // «Внутренняя ошибка сервера» - ошибка в коде и т.п.
        'NotImplemented' => 501, // «Метод не реализован» - Пришел запрос на использование метода, которого в API не существует.
    );


}