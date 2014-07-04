<?php
$this->breadcrumbs=array(
	Yii::t('bank','Banks')=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('bank','Banks'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('bank','Bank'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('bank','Bank'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('bank','Bank'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('bank','Banks'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('bank','Bank').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'title',
),
)); ?>
