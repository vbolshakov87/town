/**
 * @category	Yar
 * 2013 Yar LTD
 */

"use strict";

/*
* Vars
*/
application.vars = {};


/**
 * Common
 */
application.blocks.common = function()
{
	/**
	 * Window resize handler
	 *
	 * @return void
	 */
	var onWindowResize = function()
	{
		application.vars.dHeight = $(document).height();
		application.vars.dWidth = $(document).height();
		application.vars.wWidth = $(window).width();
		application.vars.wHeight = $(window).height();
	};
	
	/**
	 * Инициализирует UI в заданном элементе DOM
	 *
	 * @param string|object DOM element selector
	 * @return void
	 */
	this.initDOM = function(selector)
	{
		var domElement = $(selector || 'body');
		
		if($.placeholder)
			domElement.find('input[placeholder], textarea[placeholder]').placeholder();
		
		$('select.sel', domElement).customSelect();
	};
	
	/**
	 * Init
	 *
	 * @return void
	 */
	this.init = function()
	{
		$(window).resize(function(){
			onWindowResize();
		});
		onWindowResize();
		
		this.initDOM();
	};
};




/**
 * Main gallery
 */
application.blocks.maingal = function()
{
	/**
	 * This object link
	 */
	var maingalOb = this;
	
	
	/**
	 * Check block
	 *
	 * @return boolean
	 */
	this.exists = function()
	{
		return $('#maingal').length > 0;
	};
	
	/**
	 * Init block
	 *
	 * @return void
	 */
	this.init = function()
	{
		var maingal = $('#maingal');
		var panes = $('div.pane', maingal);
		var cnt = panes.length;
		var activePane = panes.filter('.active');
		var currentItem = panes.index(activePane);
		var prev = $('a.prev', maingal);
		var next = $('a.next', maingal);
		
		prev.click(function(){
			currentItem--;
			if(currentItem < 0)
				currentItem = cnt - 1;
			
			var targetPane = panes.eq(currentItem);
			activePane.fadeOut('fast');
			targetPane.fadeIn('fast');
			activePane = targetPane;
			
			return false;
		});
		
		next.click(function(){
			currentItem++;
			if(currentItem >= cnt)
				currentItem = 0;
			
			var targetPane = panes.eq(currentItem);
			activePane.fadeOut('fast');
			targetPane.fadeIn('fast');
			activePane = targetPane;
			
			return false;
		});
	};
};





/**
 * Photo gallery
 */
application.blocks.photos = function()
{
	/**
	 * This object link
	 */
	var photosOb = this;
	
	
	/**
	 * Check block
	 *
	 * @return boolean
	 */
	this.exists = function()
	{
		return $('#centuryScroll').length > 0;
	};
	
	/**
	 * Init block
	 *
	 * @return void
	 */
	this.init = function()
	{
		var dragFlag = false;
		var centuryScroll = $('#centuryScroll');
		var centuryTool = $('i', centuryScroll);
		
		var maxPos = $('#centuryScroll div.width').width() - centuryTool.width();
		
		var drag = centuryTool.draggable({
				axis: "x",
				containment: "#centuryScroll div.width",
				scroll: false,
				drag: function( event, ui ) {
					dragFlag = true;
					
					var pos = ui.position.left;
					var dHeight = application.vars.dHeight - application.vars.wHeight;
					
					var scrollTop = pos * dHeight / maxPos;
					scrollTop = Math.abs(scrollTop - dHeight); // reverse
					
					$('html, body').scrollTop(scrollTop);
				}
			});
		
		
		//Scroll handler
		$(window).scroll(function()
		{
			if(dragFlag) {
				dragFlag = false;
			} else {
				var scrollTop = $(this).scrollTop(); 
				var dHeight = application.vars.dHeight - application.vars.wHeight;
				
				var pos = scrollTop * maxPos / dHeight;
				pos = Math.abs(pos - maxPos); // reverse
				
				centuryTool.css({left: pos});
			}
		});
		
		$(window).trigger('scroll');
	};
};



$(document).ready(function(){

    $('.content-story-detail .col-cont').each(function () {
        $(this).find('img').each(function(){
            var $img = $(this),
                href = $img.attr('src'),
                title = $img.attr('title');
            if ($img.parent().prop('href') == undefined) {
                $img.wrap('<a href="' + href + '" class="fancybox-gallery" rel="fancybox" title="'+title+'"></a>');
            }
        });
    })


    $(".fancybox-gallery").fancybox({
        prevEffect		: 'none',
        nextEffect		: 'none',
        closeBtn		: false,
        helpers		: {
            title	: { type : 'inside' },
            buttons	: {},
            thumbs	: {
                width	: 50,
                height	: 50
            }
        }
    });


    $('#next').click(function(e){
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            timeout : 3000,
            type : 'GET',
            data : {
                page : $this.data('page')
            },
            url : $this.data('href'),
            dataType : 'json',
            error : function(data){
                alert(data.errorText);
            },
            success : function(data) {
                $this.parent().parent().find('.articles').append(data.items);
                $this.data('page', (data.page + 1)).html(data.pageText);
                if (data.countRemains < 1) {
                    $this.parent().hide();
                    $this.parent().parent().find('.all-begin').show();
                }
            }
        })
    });


    $('#category_change').change(function(){
        var $this = $(this);
        var baseUrl = $this.data('base_url');
        if ($this.val() != 'all') {
            window.location.href = baseUrl + 'rubric-' + $this.val() + '/';
        }
        else {
            window.location.href = baseUrl;
        }
    });

    $("img.lazy").lazyload({
        threshold : 200
    });
});


function updateScore(rating, score, essenceId, essenceType)
{
    $(rating).find('img').off('mousemove').off('click').off('mouseover').off('mouseout').off('mouseleave');

    $.ajax({
        timeout : 3000,
        type : 'GET',
        data : {
            essenceId : essenceId,
            essenceType : essenceType,
            score : score
        },
        url : '/index/changeRating',
        dataType : 'json',
        error : function(data){
            alert(data.errorText);
        },
        success : function(data) {
            var currentRating = data.data.weight;
            var photoSrc = $(rating).find('img:first').attr('src').replace('on', '#type#').replace('off', '#type#').replace('half', '#type#');
            var remains = currentRating;
            $(rating).find('img').each(function(){
               if (remains >= 0.75) {
                   $(this).prop('src', photoSrc.replace('#type#', 'on'));
                   remains -= 1;
               } else if (remains >= 0.25) {
                   $(this).prop('src', photoSrc.replace('#type#', 'half'));
                   remains = 0;
               } else {
                   $(this).prop('src', photoSrc.replace('#type#', 'off'));
                   remains = 0;
               }
            });
        }
    });
}