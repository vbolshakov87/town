/**
 * @category	Yar
 * 2013 Yar LTD
 */

"use strict";

/**
 * Application
 */
var application = new function()
{
	/**
	 * blocks
	 *
	 * @var object
	 */
	this.blocks = {};
	
	/**
	 * blocks Init Callbacks
	 *
	 * @var array
	 */
	var blocksInitCallbacks = [];
	
	/**
	 * on Blocks Init Complete
	 *
	 * @param object callback Ф-я обратного вызова
	 * @param object context Контекст вызова ф-ии
	 * @return void
	 */
	this.onBlocksInitComplete = function(callback, context)
	{
		context = context || this;
		blocksInitCallbacks.push({
			callback: callback,
			context: context
		});
	};
	
	
	/* Init application */
	$(function()
	{
		// Init blocks
		$.each(application.blocks, function(index)
		{
			//this.prototype._constructor = this;
			application.blocks[index] = new this();
		});
		$.each(application.blocks, function(index)
		{
			if((this.exists ? this.exists() : true) && this.init && !this.initialized)
			{
				this.init();
				this.initialized = true;
			}
		});
		for(var i = 0; i < blocksInitCallbacks.length; i++)
		{
			blocksInitCallbacks[i].callback.call(blocksInitCallbacks[i].context);
		};
	});
};



/**
 * Ajax loading
 */
application.loading = new function()
{
	/**
	 * Last object
	 *
	 * @var string|object
	 */
	var lastObject = '';
	
	/**
	 * Show
	 *
	 * @param string|object selector Селектор элемента, у которого отображается индикатор
	 * @return void
	 */
	this.show = function(selector)
	{
		lastObject = selector = selector || 'body';
		$(selector)
			.addClass('loading-indicator')
			.append('<div class="loading-layer"></div><div class="loading-icon"></div>');
	};
	
	/**
	 * Hide
	 *
	 * @param string|object selector Селектор элемента, у которого отображается индикатор
	 * @return void
	 */
	this.hide = function(selector)
	{
		selector = selector || lastObject;
		$(selector)
			.removeClass('loading-indicator')
			.find('> .loading-layer, > .loading-icon').remove();
	};
};




/**
 * Работа с историей браузера
 * 
 * @param string callback Имя ф-ии обратного вызова, вызываемой при переходах
 * @param object data Данные текущей страницы
 */
application.history = function(callback, data)
{
	/**
	 * Формирует history state
	 *
	 * @param object data State data
	 * @return object
	 */
	var buildState = function(data)
	{
		var state = {
			data: data instanceof Object ? data : {}
		};
		
		if(state.data.title === undefined)
			state.data.title = document.title;
		
		state.generatedByApplicationHistory = true;
		state.handledBy = callback;
		
		return state;
	};
	
	/**
	 * Добавляет обработчик браузерного события
	 *
	 * @return void
	 */
	var addListener = function()
	{
		if(window.addEventListener)
		{
			window.addEventListener('popstate', function(event)
			{
				//Пропускаем события, созданные не через application.history (например, Chrome такие генерирует)
				if(!(event.state instanceof Object) || event.state.generatedByApplicationHistory === undefined)
					return;
				
				if(event.state.data !== undefined && event.state.data.title !== undefined)
					document.title = event.state.data.title;
				
				//Дергаем ф-ии обратного вызова только для своих хозяев
				if(event.state.handledBy && event.state.handledBy == callback)
					(new Function('url, data', event.state.handledBy + '(url, data);'))(document.location.href, event.state.data);
			}, false);
		}
	};
	
	/**
	 * Возвращает текущий пункт истории
	 *
	 * @return object
	 */
	this.current = function()
	{
		return history.state;
	};
	
	/**
	 * Обновляет текущий пункт истории
	 *
	 * @param string url URL
	 * @param object data Данные
	 * @return void
	 */
	this.replace = function(url, data)
	{
		if(history.replaceState)
		{
			var state = buildState(data);
			
			history.replaceState(state, state.data.title, application.utils.url.getFull(url));
		}
	};
	
	/**
	 * Добавляет новый пункт в историю
	 *
	 * @param string url URL
	 * @param object data Данные
	 * @return void
	 */
	this.push = function(url, data)
	{
		if(history.pushState)
		{
			var state = buildState(data);
			
			history.pushState(state, state.data.title, application.utils.url.getFull(url));
		}
	};
	
	
	
	
	/**
	 * Инициализия
	 */
	this.replace(document.location.href, data);
	
	addListener();
};

/**
 * Позволяет получить singleton instance application.history
 *
 * @param string callback Имя ф-ии обратного вызова, вызываемой при переходах
 * @param object data Данные текущей страницы
 * 
 * @return application.history
 */
application.history.getInstance = function(callback, data)
{
	if(this.instances === undefined)
		this.instances = {};
	
	if(this.instances[callback] === undefined)
		this.instances[callback] = new application.history(callback, data);
	
	return this.instances[callback];
}




/**
 * Утилиты для работы с Cookie
 */
application.cookie =
{
	/**
	 * Set cookie
	 *
	 * @param string name Cookie name
	 * @param string value Cookie value
	 * @param string time Lifetime
	 * @param string path
	 * @return void
	 */
	set: function(name, value, time, path)
	{
		var time = application.utils.isUndefined(time) ? 0 : time;
		var path = application.utils.isUndefined(path) ? '/' : path;
		var expires = new Date();
		time = expires.getTime() + (time * 1000);
		
		expires.setTime(time);
		document.cookie = name + '=' + value + '; expires=' + expires.toGMTString() + "; path=" + path;
	},
	
	/**
	 * Get cookie
	 *
	 * @param string name Cookie name
	 * @return string Cookie value
	 */
	get: function(name)
	{
		var cookie = ' ' + document.cookie;
		var search = ' ' + name + '=';
		var setStr = null;
		var offset = 0;
		var end = 0;
		if(cookie.length > 0)
		{
			offset = cookie.indexOf(search);
			if(offset != -1)
			{
				offset += search.length;
				end = cookie.indexOf(';', offset);
				if(end == -1)
					end = cookie.length;
				
				setStr = unescape(cookie.substring(offset, end));
			}
		}
		
		return(setStr);
	}
};




/**
 * User-agent пользователя
 */
application.ua = new function()
{
	/**
	 * User agent  - iPad
	 *
	 * @var boolean
	 */
	this.isIPad = /iPad/i.test(navigator.userAgent);
	
	/**
	 * User agent  - iPhone
	 *
	 * @var boolean
	 */
	this.isIPhone = /iPhone OS/i.test(navigator.userAgent);
	
	/**
	 * User agent  - Android
	 *
	 * @var boolean
	 */
	this.isAndroid = /Android/i.test(navigator.userAgent);
	
	/**
	 * User agent поддерживает WebKit-фишки
	 *
	 * @var boolean
	 */
	this.isWebKit = /WebKit/i.test(navigator.userAgent);
	
	/**
	 * User agent имеет тоuch интерфейс
	 *
	 * @var boolean
	 */
	this.isTouchable = function()
	{
		var result = (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch);
		this.isTouchable = function()
		{
			return result;
		};
		return result;
	};
};




/**
 * utils
 */
application.utils = new function()
{
	/**
	 * Check undefined
	 *
	 * @param string xvar Variable to check
	 * @return boolean
	 */
	this.isUndefined = function(xvar)
	{
		return typeof xvar == 'undefined' ? true : false;
	};
};
