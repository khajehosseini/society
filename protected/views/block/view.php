<?php
$this->breadcrumbs=array(
	Yii::t('block','Blocks')=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('block','Blocks'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('block','Block'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('block','Block'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('block','Block'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('block','Blocks'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('block','Block').' '	. Yii::t('general','#');?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model->with('municipalityCode'),
'attributes'=>array(
		'id',
		'name',
		'municipalityCode.name',
		'sort_number',
		'gas_meter_num',
		'water_meter_num',
		'common_elect_meter_num',
		'count_unity',
),
)); ?>
