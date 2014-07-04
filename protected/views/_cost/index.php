<?php
$this->breadcrumbs=array(
	'Costs',
);

$this->menu=array(
array('label'=>'Create Cost','url'=>array('create')),
array('label'=>'Manage Cost','url'=>array('admin')),
);
?>

<h1>Costs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
