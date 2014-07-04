<?php
$this->breadcrumbs=array(
	'Costs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Cost','url'=>array('index')),
array('label'=>'Create Cost','url'=>array('create')),
array('label'=>'Update Cost','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Cost','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Cost','url'=>array('admin')),
);
?>

<h1>View Cost #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'blockCode.name',
		'description',
		'costTypeCode.title',
		'amount',
		'paymentCode.title',
		'transaction_num',
		'date_cheque',
		'bankCode.title',
		'create_date',
),
)); ?>
