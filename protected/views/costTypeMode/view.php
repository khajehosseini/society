<?php
$this->breadcrumbs=array(
	Yii::t('cost_type_mode','cost_type_modes')=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('cost_type_mode','cost_type_mode'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('cost_type_mode','cost_type_mode').' '	. Yii::t('general','#');	?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'title',
),
)); ?>
