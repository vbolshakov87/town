<?/**
 * @var $this FrontController
 */?>
<aside class="col-right">

	<?$this->widget('LastGalleryWidget');?>
	<?$this->widget('PollWidget');?>

	<?$this->widget('ContentBlockWidget', array('name' => 'why'));?>


	<?$this->widget('AllStatWidget');?>
</aside>