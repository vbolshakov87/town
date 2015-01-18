<?Yii::app()->getClientScript()->registerScriptFile('//yandex.st/share/share.js');?>
<div class="tools block">
	<div class="tool-item">
		<a class="tool fav">Оценить</a>
		<?=$this->clips['ratingStars'];?>
	</div>
	<div class="tool-item">
		<a class="tool print" onClick="window.print();return false">Распечатать</a>
	</div>
	<div class="tool-item">
		<span class="tool share">Поделиться</span>
		<div class="yashare-auto-init" data-yashareL10n="ru"
	     data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div>
	</div>
</div>