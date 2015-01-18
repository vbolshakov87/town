<?/**
 * @var $this GalleryAdminWidget
 * @var $gallery GalleryPhoto[]
 * */?>
<script type="text/javascript">
	$(document).ready(function(){

		$('.fancybox').fancybox();
		$('.fancybox-ajax').fancybox({
			type : 'ajax'
		});
		$('.gallery').sortable({
			update: function( event, ui ) {
				var resultIds = [];
				$('.rain').each(function(){
					resultIds.push($(this).data('id'));
				});

				$.ajax({
					type: "POST",
					url: "<?=Yii::app()->createUrl('admin/photoGallery/resort')?>",
					data: { ids: resultIds }
				});
			}
		});

		$('#file_upload').uploadify({
			'uploader'  	: '/ajax_upload/uploadify.swf',
			'script'    	: '<?=Yii::app()->createUrl('admin/photoGallery/upload', array('essence' => $this->essence, 'essence_id' => $this->essence_id))?>',
			'cancelImg' 	: '/ajax_upload/cancel.png',
			'folder'    	: '/content/',
			'sizeLimit' 	: 10242880,
			'fileExt'   	: '*.jpg;*.png',
			'fileDesc'  	: 'Image Files (.JPG, .PNG)',
			'buttonImg' 	: '/ajax_upload/choose.png',
			'height'    	: 33,
			'width'			: 130,
			'auto'      	: true,
			'multi'      	: true,
			'onComplete'  	: function(event, ID, fileObj, response, data) {
				uploadData = $.parseJSON(response);
				$('.gallery').append(uploadData.html);
				$('#rain'+uploadData.id+' .fancybox').fancybox();
			}
		});


		$('.gallery').delegate('.btn-delete', 'click', function(){
			var $this = $(this);
			if (!$this.hasClass('btn-delete-confirmed'))
				return false;

			var $element = $this.parents('.rain');

			$.ajax({
				type: "POST",
				url: "<?=Yii::app()->createUrl('admin/photoGallery/delete')?>",
				data: { id: $element.data('id') }
			}).done(function( msg ) {
					data = $.parseJSON(msg);
					if (data.status == 'done')
						$element.remove();
				});
		});

		$('body').delegate('#gallery-rename-form', 'submit', function(){
			var $this = $(this);
			var $formWrapper = $this.parents('#form-wrapper');
			var $fancyboxWrapper = $formWrapper.parent();
			$.ajax({
				type: 'POST',
				url: '<?=Yii::app()->createUrl('admin/photoGallery/rename')?>?id='+$formWrapper.data('id'),
				data: $this.serialize()
			}).done(function( msg ) {
					$formWrapper.remove();
					$fancyboxWrapper.append(msg);
				});
			return false;
		});
	});
</script>

<h2>Галерея фотографий</h2>
<ul class="gallery cf">
    <?foreach ($gallery as $image) :
		$this->render('application.modules.admin.views.photoGallery._photoInList', array('image' => $image ));
	endforeach;?>
</ul>
<div class="clearfix"></div>
<div style="margin-bottom: 50px">
    <h2>Добавить еще фотографии</h2>
    <input id="file_upload" name="file_upload" type="file" />
</div>