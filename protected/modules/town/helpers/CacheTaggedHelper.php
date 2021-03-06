<?php
class CacheTaggedHelper {
	const VERSION = "0.01";

	static private $_cache = null;

	static public function init(ICache $cacheId = null)
	{
		if ($cacheId === null)
		{
			if (self::$_cache !== null) {
				return true;
			}

			// По умолчанию берём глобально определенный кеш
			self::$_cache = Yii::app()->cache;
		}
		else {
			self::$_cache = $cacheId;
		}

		return (self::$_cache !== null);
	}

	/**
	 * Удаление тегов кеша
	 * Вместе с тегами становятся не актиуальным кеш, помеченный этими тегами
	 */
	static public function deleteByTags($tags = array()) {

		if (!self::init()) return false;

		if (is_string($tags)) {
			$tags = array($tags);
		}

		if (is_array($tags)) {
			foreach ($tags as $tag) {
				self::$_cache->delete(self::mangleTag($tag));
			}
		}

		return true;
	}

	/**
	 * Генерит название ключа по имени тега
	 */
	static public function mangleTag($tag) {
		return get_class() . "_" . self::VERSION . "_" . $tag;
	}

	/**
	 * Применяет метод mangleTag к списку тегов и возвращает массив ключей
	 * @see self::_mangleTag
	 */
	static public function mangleTags($tags) {
		foreach ($tags as $i => $tag) {
			$tags[$i] = self::mangleTag($tag);
		}
		return $tags;
	}

	/**
	 * Генерит новый уникальный идентификатор для версии тега
	 */
	static public function generateNewTagVersion() {
		static $counter = 0;
		$counter++;
		return md5(microtime() . getmypid() . uniqid('')) . '_' . $counter;
	}
}