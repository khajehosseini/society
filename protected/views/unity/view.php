<?php
$this->breadcrumbs=array(
	Yii::t('Unitiy','Unities')=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('Unitiy','Unities'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('Unitiy','Unitiy'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('Unitiy','Unitiy'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('Unitiy','Unitiy').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model->with('blockCode'),
'attributes'=>array(
		'id',
		'name',
		'blockCode.name',
		'elect_meter_num',
		'meter',
		'stage',
),
)); ?>
