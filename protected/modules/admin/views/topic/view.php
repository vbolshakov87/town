<?php
/* @var $this TopicController */
/* @var $model Topic */

$this->breadcrumbs=array(
	'Темы'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Добавить тему', 'url'=>array('create')),
	array('label'=>'Редактировать тему', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Темы', 'url'=>array('admin')),
);
?>

<h1>Просмотр темы #<?php echo $model->id; ?></h1>

<table class="table table-bordered table-striped">
	<tr>
		<th>Название</th>
		<td><?=$model->title?></td>
	</tr>
	<tr>
		<th>Выбрано группой</th>
		<td><?=!(empty($model->user_group_id) ? $model->userGroup->name : '');?></td>
	</tr>
	<tr>
		<th>Статус</th>
		<td><?=Topic::getStatusLabel($model->status)?></td>
	</tr>
	<tr>
		<th>Создано</th>
		<td><?=($model->create_time > 0 ? date("d.m.Y H:i", $model->create_time) : "Не задано")?></td>
	</tr>
	<tr>
		<th>Выбрано</th>
		<td><?=($model->booked_time > 0 ? date("d.m.Y H:i", $model->booked_time) : "Не задано")?></td>
	</tr>
</table>