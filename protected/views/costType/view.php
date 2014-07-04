<?php
$this->breadcrumbs=array(
	Yii::t('cost_type','cost_types')=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type','cost_type'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type','cost_type'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('cost_type','cost_type'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('cost_type','cost_type'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('cost_type','cost_type'),'url'=>array('admin')),
);
?>

<h1>View CostType #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'costTypeModeCode.title',
		'title',
),
)); ?>
