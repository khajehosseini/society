<?php
$this->breadcrumbs=array(
	Yii::t('block','Blocks')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('block','Blocks'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('block','Block'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('block','Block'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('block','Block'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('block','Block');?><?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>