<?php
$this->breadcrumbs=array(
	Yii::t('householder','householders')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('householder','householder'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('householder','householder'),'url'=>array('create')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('householder','householder'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Create').' '.Yii::t('householder','householder'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('householder','householder');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model	,'block_id'	=>	$block_id)); ?>