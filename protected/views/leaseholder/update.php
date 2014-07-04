<?php
$this->breadcrumbs=array(
	Yii::t('leaseholder','leaseholders')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('leaseholder','leaseholder'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('leaseholder','leaseholder');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model	,'block_id'	=>	$block_id)); ?>