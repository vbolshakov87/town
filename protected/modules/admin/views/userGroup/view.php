<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */

$this->breadcrumbs=array(
	'User Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserGroup', 'url'=>array('index')),
	array('label'=>'Create UserGroup', 'url'=>array('create')),
	array('label'=>'Update UserGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserGroup', 'url'=>array('admin')),
);
?>

<h1>Группа #<?php echo $model->id; ?></h1>

<p><b>ID:</b> <?=$model->id?></p>
<p><b>Название группы:</b> <?=$model->name?></p>
<p><b>Код группы:</b> <?=$model->code?></p>

<h2>Пользователи группы</h2>

<table class="table table-bordered">
<?foreach ($model->linkUserGroupUsers as $linkUserGroupUser) :?>
<tr>
	<td><?=$linkUserGroupUser->user->name?></td>
	<td><button type="button" data-id="<?=$linkUserGroupUser->user_id?>" class="btn btn-primary btn-xs btn-danger" onclick="confirm('Вы уверены?') ? $(this).addClass('btn-delete-confirmed') : false;">Удалить</button></td>
</tr>
<?endforeach;?>
</table>
<script>
	$('.btn-danger').click(function(){
		if (!$(this).hasClass('btn-delete-confirmed')) {
			return false;
		}

		location.href = '/admin/userGroup/deleteUserFromGroup?groupId=<?=$model->id?>&userId'+$(this).data('id');
	})
</script>