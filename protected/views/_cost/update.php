<?php
$this->breadcrumbs=array(
	'Costs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Cost','url'=>array('index')),
	array('label'=>'Create Cost','url'=>array('create')),
	array('label'=>'View Cost','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Cost','url'=>array('admin')),
	);
	?>

	<h1>Update Cost <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>