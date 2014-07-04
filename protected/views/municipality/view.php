<?php
$this->breadcrumbs=array(
	Yii::t('municipalitiy','municipalities')=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('municipalitiy','municipalitiy'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('municipalitiy','municipalitiy'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('municipalitiy','municipalitiy').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
),
)); ?>
