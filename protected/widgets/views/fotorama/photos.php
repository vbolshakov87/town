<?/**
 * @var $this FotoramaWidget
 */ ?>
<div class="fotorama"
     data-nav="thumbs"
     data-width="<?=$this->width?>"
     data-height="<?=$this->height?>"
     data-allowfullscreen="true"
     data-hash="true"
     data-keyboard="true"
     data-transition="dissolve"
     data-thumbheight="64"
     data-swipe="true"
     data-click="true"
     data-loop="true"
	>
	<?foreach ($data as $photo) :?>
		<a href="<?=$photo['photoSrc']?>" id="<?=$photo['id']?>" data-caption="<?=$photo['title']?>"><img src="<?=$photo['photoNavSrc']?>" <?=$photo['size']?> alt="<?=$photo['title']?>" title="<?=$photo['title']?>" data-caption="<?=$photo['title']?>" /></a>
	<?endforeach;?>
</div>