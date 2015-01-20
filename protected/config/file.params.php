<?php

/**
 * Параметры
 * width - выходная ширина
 * height - выходная высота
 * crop - true|false - вырезает часть из изображения по заданным размерам относительно центра
 * proportion - true|false сохранить пропорции
 * path - папка в которой хранится файл
 * source - название типа источника картинки
 * domain_route - роут, который будет использоваться в createURL для данного типа картинок. 'domain_route' => ''
 */

$fileParams = array(

	// изображения загруженные через визуальный редактор
	'redactor/source' => array('path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/redactor', 'folder' => '/source/redactor', 'resize' => false, 'original' => true),
	'redactor' => array(
		'source' => 'redactor/source', 'width' => 720, 'height' => 720, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/redactor', 'folder'=>'/uploads/redactor', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),

	'story/source' => array('path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/story', 'folder' => '/source/story', 'resize' => false, 'original' => true),

	// изображения для показа в списке в админке
	'story_admin/form' => array(
		'source' => 'story/source', 'width' => 500, 'height' => 500, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/story_form', 'folder'=>'/uploads/story_form', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'story/thumb' => array(
		'source' => 'story/source', 'width' => 640, 'height' => 800, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/story_on_thumb', 'folder'=>'/uploads/story_on_thumb', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'story/topIndex' => array(
		'source' => 'story/source', 'width' => 630, 'height' => 391, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/story_top_index', 'folder'=>'/uploads/story_top_index', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'story/top' => array(
		'source' => 'story/source', 'width' => 300, 'height' => 189, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/story_top', 'folder'=>'/uploads/story_top', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'story/detail' => array (
		'source' => 'story/source', 'width' => 1000, 'height' => 1000, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/story_detail', 'folder'=>'/uploads/story_detail', 'resize' => true, 'original' => false, 'crop' => false, 'proportion' => true,
	),



	'photostory/source' => array('path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/photoStory', 'folder' => '/source/photoStory', 'resize' => false, 'original' => true),

	// изображения для показа в списке в админке
	'photoStory_admin/form' => array(
		'source' => 'photostory/source', 'width' => 500, 'height' => 500, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_form', 'folder'=>'/uploads/photo_story_form', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'photoStory/thumb' => array(
		'source' => 'photostory/source', 'width' => 260, 'height' => 500, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_thumb', 'folder'=>'/uploads/photo_story_thumb', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'photoStory/top' => array(
		'source' => 'photostory/source', 'width' => 300, 'height' => 189, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_top', 'folder'=>'/uploads/photo_story_top', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'photoStory/topIndex' => array(
		'source' => 'photostory/source', 'width' => 630, 'height' => 391, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_top_index', 'folder'=>'/uploads/photo_story_top_index', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'photoStory/detail' => array (
		'source' => 'photostory/source', 'width' => 1000, 'height' => 1000, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_detail', 'folder'=>'/uploads/photo_story_detail', 'resize' => true, 'original' => false, 'crop' => false, 'proportion' => true,
	),
	'photoStory/sidebar' => array (
		'source' => 'photostory/source', 'width' => 300, 'height' => 210, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/sidebar', 'folder'=>'/uploads/sidebar', 'resize' => false, 'original' => false, 'crop' => true, 'proportion' => true,
	),


	'figure/source' => array('path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/figure', 'folder' => '/source/figure', 'resize' => false, 'original' => true),

	// изображения для показа в списке в админке
	'figure_admin/form' => array(
		'source' => 'story/source', 'width' => 500, 'height' => 500, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/figure_form', 'folder'=>'/uploads/figure_form', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'figure/thumb' => array(
		'source' => 'story/figure', 'width' => 260, 'height' => 500, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/figure_thumb', 'folder'=>'/uploads/figure_thumb', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'figure/topIndex' => array(
		'source' => 'figure/source', 'width' => 630, 'height' => 391, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/figure_top_index', 'folder'=>'/uploads/figure_top_index', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'figure/top' => array(
		'source' => 'photostory/source', 'width' => 300, 'height' => 189, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/figure_top', 'folder'=>'/uploads/figure_top', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'figure/detail' => array (
		'source' => 'figure/source', 'width' => 1000, 'height' => 1000, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/figure_detail', 'folder'=>'/uploads/figure_detail', 'resize' => true, 'original' => false, 'crop' => false, 'proportion' => true,
	),

	'gallery/source' => array(
		'path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/gallery', 'folder' => '/source/gallery', 'resize' => false, 'original' => true
	),
	'galleryphoto/source' => array(
		'path' => $_SERVER['DOCUMENT_ROOT'].'/../images_source/gallery', 'folder' => '/source/gallery', 'resize' => false, 'original' => true
	),
	'gallery/list' => array (
		'source' => 'gallery/source', 'width' => 200, 'height' => 200, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/gallery_list', 'folder'=>'/uploads/gallery_list', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'gallery/thumb' => array (
		'source' => 'gallery/source', 'width' => 260, 'height' => 186, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/gallery_thumb', 'folder'=>'/uploads/gallery_thumb', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'gallery/detail' => array (
		'source' => 'gallery/source', 'width' => 1000, 'height' => 1000, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/gallery_detail', 'folder'=>'/uploads/gallery_detail', 'resize' => true, 'original' => false, 'crop' => false, 'proportion' => true,
	),
	'gallery/photoStoryList' => array (
		'source' => 'gallery/source', 'width' => 246, 'height' => 220, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_list', 'folder'=>'/uploads/photo_story_list', 'resize' => false, 'original' => false,  'crop' => true, 'proportion' => true,
	),
	'photoStoryDetail/list' => array(
		'source' => 'gallery/source', 'width' => 3000, 'height' => 1200, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_detail_list', 'folder'=>'/uploads/photo_story_detail_list', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	'photoStoryDetail/thumb' => array (
		'source' => 'gallery/source', 'width' => 300, 'height' => 64, 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/photo_story_detail_thumb', 'folder'=>'/uploads/photo_story_detail_thumb', 'resize' => true, 'original' => false,  'crop' => false, 'proportion' => true,
	),
	// $item




	// pdf
	'fotoobraz/pdf' => array (
		'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/fotoobraz_pdf', 'folder'=>'/uploads/fotoobraz_pdf',
	),

);

return $fileParams;