<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bolshvl
 * Date: 16.11.12
 * Time: 17:10
 * To change this template use File | Settings | File Templates.
 */
class DocumentShowStat
{
	//1x1.gif in 35 bytes!
	const GIF_1x1 = "\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\xff\x00\xff\xff\xff\x00\x00\x00\x2c\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3b";
    public $is_ok = false;
    public $is_304 = false;

	public $saved = false;

	protected $_table = null;
	protected $_id = null;

	/**
	 * Возвращает TRUE, если клиент является браузером и FALSE в противном случае (клиент явл. роботом).
	 * Определение браузера происходит по заголовку запроса HTTP_USER_AGENT согласно спецификации.
	 *
	 * @param  string $user_agent  E.g. $_SERVER['HTTP_USER_AGENT']
	 * @return bool
	 */
	public /*static*/ function is_browser($user_agent)
	{
		/*
        РОБОТЫ:
          Детектируем роботы: поисковые машины, скрипты, программы поиска уязвимостей
          Примеры некоторых HTTP_USER_AGENT:
          http://yandex.ru/     http://webmaster.yandex.ru/faq.xml?id=502499#user-agent
                                У Яндекса есть несколько роботов, которые представляются по-разному.
                                  "Yandex/1.01.001 (compatible; Win16; I)" — основной индексирующий робот
                                  "Yandex/1.01.001 (compatible; Win16; P)" — индексатор картинок
                                  "Yandex/1.01.001 (compatible; Win16; H)" — робот, определяющий зеркала сайтов
                                  "Yandex/1.02.000 (compatible; Win16; F)" — робот, индексирующий пиктограммы сайтов (favicons)
                                  "Yandex/1.03.003 (compatible; Win16; D)" — робот, обращающийся к странице при добавлении ее через форму «Добавить URL»
                                  "Yandex/1.03.000 (compatible; Win16; M)" — робот, обращающийся при открытии страницы по ссылке «Найденные слова»
                                  "YaDirectBot/1.0 (compatible; Win16; I)" — робот, индексирующий страницы сайтов, участвующих в Рекламной сети Яндекса
                                Кроме роботов у Яндекса есть несколько агентов-«простукивалок», которые определяют, доступен ли в данный момент сайт или документ, на который стоит ссылка в соответствующем сервисе.
                                  "Yandex/2.01.000 (compatible; Win16; Dyatel; C)" — «простукивалка» Яндекс.Каталога. Если сайт недоступен в течение нескольких дней, он снимается с публикации. Как только сайт начинает отвечать, он автоматически появляется в Каталоге.
                                  "Yandex/2.01.000 (compatible; Win16; Dyatel; Z)" — «простукивалка» Яндекс.Закладок. Ссылки на недоступные сайты помечаются серым цветом.
                                  "Yandex/2.01.000 (compatible; Win16; Dyatel; D)" — «простукивалка» Яндекс.Директа. Она проверяет корректность ссылок из объявлений перед модерацией. Никаких автоматических действий не предпринимается.
                                  "Yandex/2.01.000 (compatible; Win16; Dyatel; N)" — «простукивалка» Яндекс.Новостей. Она формирует отчет для контент-менеджера, который оценивает масштаб проблем и, при необходимости, связывается с партнером.
          http://rambler.ru/      "StackRambler/2.0 (MSIE incompatible)"
          http://google.com/      "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"
          http://yahoo.com/       "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)"
          http://search.msn.com/  "msnbot/1.0 (+http://search.msn.com/msnbot.htm)"
          XSpider 7.5             "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 7.0) PTX"

        БРАУЗЕРЫ:
          Internet Explorer       Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)
                                  Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ;  Embedded Web Browser from: http://bsalsa.com/)
                                  Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; <a href='http://radioclicker.com'>radio</a>; RadioClicker Lite; .NET CLR 2.0.50727)
          FireFox                 Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1) Gecko/20061010 Firefox/2.0
          Opera                   Opera/9.23 (Windows NT 5.1; U; ru)
                                  Opera/9.61 (Windows NT 5.1; U; ru) Presto/2.1.1
          Safari                  Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU) AppleWebKit/525.18 (KHTML, like Gecko) Version/3.1.1 Safari/525.17
		*/
		$is_robot =
			#не строка
			! is_string($user_agent)
				#~ анонимные/неграмотные роботы
				|| strlen($user_agent) < 8
				#Browsers: IE, Opera, Firefox, Safari, Konqueror
				|| ! preg_match('/^(?:Mozilla|Opera)\/\d+(?>\.\d+)+\x20/sSX', $user_agent)
				#параноидальный способ (в большинстве случаев сработают первые 2 проверки):
				|| preg_match('/	(?<![a-z])  #предыдущий символ не буква
								(?:		#сигнатуры известных роботов:
										Yandex|Googlebot|StackRambler|Aport|Mail\.ru|yahoo|goku|msnbot|cazoodlebot|irlbot|gigabot|altavista|findlinks|ApacheBench #|PTX

										#теоретически возможные названия остальных роботов:
									|	spider|crawler|search|robot

										#DEPRECATED, т.к. плагины и надстройки к браузеру дописывают URL адреса!
										#некоторые роботы вставляют ссылки:
									#|	http:\/\/[a-z\d]+
								)
								(?![a-z])   #следующий символ не буква
							/sixSX', $user_agent);
		return $is_browser = ! $is_robot;
	}


    public function ob_done($s)
    {
        //header('X-Accel-Expires: 0');
        header_remove('X-Powered-By');

        if (! $this->is_ok) return $s;

        if ($this->is_304) {
            header('HTTP/1.0 304 Not Modified', true, 304);
            return '';
        }

        //будем показывать картинку
        $s = self::GIF_1x1;
        $etag = base_convert(md5($s), 16, 36);
        header('Content-Type: image/gif', true);
        header('Cache-Control: max-age=0, private, must-revalidate', true);
        header('ETag: ' . $etag, true);

        $length = strlen($s);
        if ($length > 0) header('Content-Length: ' . $length);
        return $s;
    }


    public function __construct($table, $id)
    {
	    $this->_table = $table;
	    $this->_id = $id;
        //обработчики в ob_start() выполнятся, даже если будет фатальная ошибка!
        ob_start(array($this, 'ob_done'));
    }


    public function run()
    {
        // id документа
        $id = $this->_id;

        //проверяем входящие параметры
        if (! isset($_SERVER['HTTP_USER_AGENT']) || ! $this->is_browser($_SERVER['HTTP_USER_AGENT'])) {
            #испорченный запрос
            header('HTTP/1.0 400 Bad Request', true, 400);
            header('X-Error-Message: Valid HTTP_USER_AGENT required!');
            $this->halt(false);
        }

        if (! isset($id)) {
            #испорченный запрос
            header('HTTP/1.0 400 Bad Request', true, 400);
            header('X-Error-Message: Valid query parameter "document_id" required!');
            $this->halt(false);
        }

        //повторно счётчик не обновляем
        if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            $etag = base_convert(md5(self::GIF_1x1), 16, 36);
            $this->is_304 = ($_SERVER['HTTP_IF_NONE_MATCH'] === $etag);
        }

        $sql = 'UPDATE `'.$this->_table.'`
				SET `visits` = IF(`hits` > 0 AND `visits` IS NULL, NULL, IFNULL(`visits`, 0) + 1)
					' . ($this->is_304 ? '' : ', `hits` = IFNULL(`hits`, 0) + 1') . '
				WHERE `id` = ' . $id . '
			';

        try {
            $sqiResult = Yii::app()->getDb()->createCommand($sql)->execute();
        }
        catch (CException $e) {
            header('HTTP/1.0 500 Internal Server Error', true, 500);
            header('X-Error-Message: Cannot execute query!');
            $this->halt(false, 'DB error');
        }
        $this->halt(true);
    }

    /**
     * Остановка выполнения
     * @param bool $ok
     * @param null $err_msg
     */
    public function halt($ok = false, $err_msg = null)
	{
		$this->is_ok = $ok;
		if (! $ok && is_string($err_msg)) trigger_error($err_msg, E_USER_ERROR);
		Yii::app()->end();
	}

}
