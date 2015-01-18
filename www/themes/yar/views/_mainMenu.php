<?php $this->widget('NavMenuWidget',array(
	'items'=>array(
		array('label'=>'О проекте', 'url'=>array('site/about')),
		array('label'=>'Дайверы', 'url'=>array('member/list')),
		array('label'=>'Дайв-клубы', 'url'=>array('club/index')),
		array('label'=>'Дайв-сайты', 'url'=>array('diveSite/index')),
		array('label'=>'Карта погружений', 'url'=>array('diveSite/map')),
	),
));?>
